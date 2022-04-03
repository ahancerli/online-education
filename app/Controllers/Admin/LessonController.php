<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 29.08.2020
 * Time: 22:14
 */

namespace App\Controllers\Admin;


use App\Models\LessonModel;
use CodeIgniter\Controller;

class LessonController extends Controller
{
    public function index()
    {
        $courses = model('CourseModel')
            ->select('id, title, course_type_id')
            ->findAll();

        return view('admin/lesson/index', compact('courses'));
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;

        $status = $this->request->getPost('query')['status'] ?? 'all';
        $courseId = $this->request->getPost('query')['course_id'] ?? 'all';

        $lessonModel = new LessonModel();
        $lessons = $lessonModel
            ->join('courses', 'courses.id = lessons.course_id')
            ->join('sections', 'sections.id = lessons.section_id', 'LEFT')
            ->select('lessons.*, courses.title AS course_name, sections.name AS section_name')
            ->orderBy($sort['field'], $sort['sort']);

        if (isset($this->request->getPost('query')['date_period'])) {
            $startDate = $this->request->getPost('query')['date_period']['start_date'] ?? null;
            $endDate = $this->request->getPost('query')['date_period']['end_date'] ?? null;

            if ($startDate && $endDate) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                $endDate = date('Y-m-d H:i:s', strtotime($endDate));

                $lessons = $lessons
                    ->where('lessons.created_at >=', $startDate)
                    ->where('lessons.created_at <', $endDate);
            }
        }

        if ($status !== 'all')
            $lessons = $lessons->where('lessons.status', $status);

        if ($courseId !== 'all')
            $lessons = $lessons->where('lessons.course_id', $courseId);

        $total = $lessons->countAllResults(false);
        $pageSize = ceil($total / $limit);

        $lessons = $lessons->findAll($limit, $start);

        return $this->response->setJSON([
            'data' => $lessons,
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

    public function create()
    {
        $mode = 'create';
        $courses = model('CourseModel')
            ->select('id, title, course_type_id')
            ->findAll();

        return view('admin/lesson/create', compact('mode', 'courses'));
    }

    public function attemptCreate()
    {
        $lessonModel = new LessonModel();
        $postData = $this->request->getPost();

        if (!$lessonModel->validate($postData))
            return redirect()->back()->withInput()->with('errors', $lessonModel->getValidationMessages());

        if (!$this->validate(['document' => 'max_size[document,1024]']))
            return redirect()->back()->withInput()->with('error', 'Yüklediğiniz dosya boyutu en fazla 1MB olabilir');

        if ($postData['course_type_id'] == 101 || $postData['course_type_id'] == 102)
            return redirect()->back()->withInput()->with('error', 'Çevrimdışı kurslar veya döküman kursları haricinde diğer kurs tiplerine ders ekleyemezsiniz');

        if ($this->request->getFile('document')->getError() != 4) {
            $documentFile = $this->request->getFile('document');

            if (!$documentFile->isValid())
                return redirect()->back()->withInput()->with('error', $documentFile->getErrorString());

            $newName = $documentFile->getRandomName();
            if (!$documentFile->move(ROOTPATH . 'public/assets/uploads/document/', $newName))
                return redirect()->back()->withInput()->with('error', 'Döküman yüklenemedi');

            $postData['document_name'] = $newName;
        }

        $postData['status'] = $this->request->getPost('status') ?? 0;

        if (!$lessonModel->insert($postData))
            return redirect()->back()->withInput()->with('error', 'Ders eklenemedi');

        return redirect()->back()->with('message', 'Ders başarıyla eklendi');
    }

    public function edit($id)
    {
        $lessonModel = new LessonModel();
        $lesson = $lessonModel->find($id);

        if (!$lesson)
            return;

        $mode = 'edit';
        $courses = model('CourseModel')
            ->select('id, title, course_type_id')
            ->findAll();

        return view('admin/lesson/create', compact('mode', 'courses', 'lesson'));
    }

    public function update()
    {
        $rules = ['lesson_id' => 'required|numeric'];

        if (!$this->validate($rules))
            return redirect()->back()->withInput()->with('error', 'Eksik veya hatalı parametre girişi');

        $lessonModel = new LessonModel();
        $postData = $this->request->getPost();

        $lessonId = $postData['lesson_id'];
        $lesson = $lessonModel->find($lessonId);

        if (!$lessonModel->validate($postData))
            return redirect()->back()->withInput()->with('errors', $lessonModel->getValidationMessages());

        if (!$this->validate(['document' => 'max_size[document,1024]']))
            return redirect()->back()->withInput()->with('error', 'Yüklediğiniz dosya boyutu en fazla 1MB olabilir');

        if ($postData['course_type_id'] == 101 || $postData['course_type_id'] == 102)
            return redirect()->back()->withInput()->with('error', 'Çevrimdışı kurslar veya döküman kursları haricinde diğer kurs tiplerine ders ekleyemezsiniz');

        if ($this->request->getFile('document')->getError() != 4) {
            $documentFile = $this->request->getFile('document');

            if (!$documentFile->isValid())
                return redirect()->back()->withInput()->with('error', $documentFile->getErrorString());

            $newName = $documentFile->getRandomName();
            if (!$documentFile->move(ROOTPATH . 'public/assets/uploads/document/', $newName))
                return redirect()->back()->withInput()->with('error', 'Döküman yüklenemedi');

            @unlink(ROOTPATH . 'public/assets/uploads/document/' . $lesson['document_name']);

            $postData['document_name'] = $newName;
        }

        $postData['status'] = $this->request->getPost('status') ?? 0;

        if (!$lessonModel->update($lessonId, $postData))
            return redirect()->back()->withInput()->with('error', 'Ders güncellenemedi');

        return redirect()->back()->with('message', 'Ders başarıyla güncellendi');
    }

    public function delete($id)
    {
        $lessonModel = new LessonModel();
        $lessonModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Ders başarıyla silindi'
        ])->setStatusCode(200);
    }
}