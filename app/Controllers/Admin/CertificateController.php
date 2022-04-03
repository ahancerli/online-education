<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 18.09.2020
 * Time: 18:31
 */

namespace App\Controllers\Admin;


use App\Models\CertificateModel;
use CodeIgniter\Controller;

class CertificateController extends Controller
{
    public function index()
    {
        $courses = model('CourseModel')->findAll();
        return view('admin/certificate/index', compact('courses'));
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;

        $courseId = $this->request->getPost('query')['course_id'] ?? 'all';

        $certificateModel = new CertificateModel();
        $certificates = $certificateModel
            ->join('users', 'users.id = certificates.user_id')
            ->join('courses', 'courses.id = certificates.course_id')
            ->select('certificates.*, users.name AS customer_name, users.email AS customer_email, courses.title AS course_name')
            ->orderBy($sort['field'], $sort['sort']);

        if (isset($this->request->getPost('query')['date_period'])) {
            $startDate = $this->request->getPost('query')['date_period']['start_date'] ?? null;
            $endDate = $this->request->getPost('query')['date_period']['end_date'] ?? null;

            if ($startDate && $endDate) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                $endDate = date('Y-m-d H:i:s', strtotime($endDate));

                $certificates = $certificates
                    ->where('certificates.created_at >=', $startDate)
                    ->where('certificates.created_at <', $endDate);
            }
        }

        if ($courseId !== 'all')
            $certificates = $certificates->where('certificates.course_id', $courseId);

        $total = $certificates->countAllResults(false);
        $pageSize = ceil($total / $limit);

        $certificates = $certificates->findAll($limit, $start);

        return $this->response->setJSON([
            'data' => $certificates,
            'meta' => [
                'field' => $sort['field'],
                'page' => intval($page),
                'pages' => $pageSize,
                'perpage' => intval($limit),
                'sort' => $sort['sort'],
                'total' => $total
            ]
        ]);
    }
}