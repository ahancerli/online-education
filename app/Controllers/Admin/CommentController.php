<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 20.08.2020
 * Time: 23:02
 */

namespace App\Controllers\Admin;

use App\Models\CommentModel;
use CodeIgniter\Controller;

class CommentController extends Controller
{
    public function index()
    {
        $courses = model('CourseModel')->select('id, title')->findAll();
        return view('admin/comment/index', compact('courses'));
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;

        $status = $this->request->getPost('query')['status'] ?? 'all';
        $courseId = $this->request->getPost('query')['course_id'] ?? 'all';

        $commentModel = new CommentModel();
        $comments = $commentModel
            ->join('users', 'users.id = comments.user_id')
            ->join('courses', 'courses.id = comments.course_id')
            ->join('ratings', 'ratings.comment_id = comments.id')
            ->select('comments.*, users.name AS user_name, courses.title AS course_name, ratings.point AS point')
            ->orderBy($sort['field'], $sort['sort']);

        if (isset($this->request->getPost('query')['date_period'])) {
            $startDate = $this->request->getPost('query')['date_period']['start_date'] ?? null;
            $endDate = $this->request->getPost('query')['date_period']['end_date'] ?? null;

            if ($startDate && $endDate) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                $endDate = date('Y-m-d H:i:s', strtotime($endDate));

                $comments = $comments
                    ->where('comments.created_at >=', $startDate)
                    ->where('comments.created_at <', $endDate);
            }
        }

        if ($status !== 'all')
            $comments = $comments->where('comments.status', $status);

        if ($courseId !== 'all')
            $comments = $comments->where('comments.course_id', $courseId);

        $total = $comments->countAllResults(false);
        $pageSize = ceil($total / $limit);

        $comments = $comments->findAll($limit, $start);

        return $this->response->setJSON([
            'data' => $comments,
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

    public function changeStatus()
    {
        $rules = [
            'comment_id' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Eksik veya hatalı parametre'
            ])->setStatusCode(422);

        $commentModel = new CommentModel();
        $commentModel->update($this->request->getPost('comment_id'), [
            'status' => $this->request->getPost('status')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Başarıyla güncellendi'
        ])->setStatusCode(200);
    }

    public function delete($id)
    {
        $commentModel = new CommentModel();
        if (!$commentModel->delete($id))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Yorum silinemedi'
            ])->setStatusCode(409);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Yorum başarıyla silindi'
        ])->setStatusCode(200);
    }
}