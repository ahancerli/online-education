<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 18.08.2020
 * Time: 22:18
 */

namespace App\Controllers\Admin;


use App\Helpers\SystemParameter;
use App\Models\CourseModel;
use App\Models\SectionModel;
use CodeIgniter\Controller;

class SectionController extends Controller
{
    public function index()
    {
        $sectionModel = new SectionModel();
        $courseModel = new CourseModel();

        $sections = $sectionModel
            ->join('courses', 'courses.id = sections.course_id')
            ->select('sections.*, courses.title AS course_name')
            ->orderBy('sections.created_at', 'desc')
            ->findAll();

        $courses = $courseModel
            ->where('course_type_id', SystemParameter::OFFLINE_COURSE)
            ->orWhere('course_type_id', SystemParameter::DOCUMENT_COURSE)
            ->findAll();

        return view('admin/section/index', compact('sections', 'courses'));
    }

    public function delete($id)
    {
        $sectionModel = new SectionModel();
        $sectionModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Bölüm başarıyla silindi'
        ])->setStatusCode(200);
    }

    public function attemptCreate()
    {
        $sectionModel = new SectionModel();
        $postData = $this->request->getPost();

        if (!$sectionModel->validate($postData))
            return $this->response->setJSON([
                'success' => false,
                'message' => $sectionModel->getValidationMessages()
            ])->setStatusCode(422);

        $sectionId = $sectionModel->insert($postData);
        $section = $sectionModel
            ->join('courses', 'courses.id = sections.course_id')
            ->select('sections.*, courses.title AS course_name')
            ->where('sections.id', $sectionId)
            ->first();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Bölüm başarıyla eklendi',
            'section' => $section
        ])->setStatusCode(200);
    }

    public function update()
    {
        if (!$this->request->getPost('section_id'))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Eksik ya da hatalı parametre'
            ])->setStatusCode(422);

        $sectionModel = new SectionModel();
        $postData = $this->request->getPost();
        $sectionId = $postData['section_id'];

        if (!$sectionModel->validate($postData))
            return $this->response->setJSON([
                'success' => false,
                'message' => $sectionModel->getValidationMessages()
            ])->setStatusCode(422);

        if (!$sectionModel->update($sectionId, $postData))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Bölüm güncellenemedi'
            ])->setStatusCode(409);

        $section = $sectionModel
            ->join('courses', 'courses.id = sections.course_id')
            ->select('sections.*, courses.title AS course_name')
            ->where('sections.id', $sectionId)
            ->first();

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Bölüm başarıyla güncellendi',
            'section' => $section
        ])->setStatusCode(200);
    }

    public function listByCourse($courseId)
    {
        $sections = model('SectionModel')
            ->where('course_id', $courseId)
            ->select('id, name')
            ->findAll();

        return $this->response->setJSON([
            'success' => true,
            'data' => $sections
        ])->setStatusCode(200);
    }
}