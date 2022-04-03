<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 16.08.2020
 * Time: 00:24
 */

namespace App\Controllers\Admin;

use App\Helpers\SystemParameter;
use App\Models\CourseModel;
use CodeIgniter\Controller;
use Config\Database;

class CourseController extends Controller
{
    public function __construct()
    {
        helper('string');
    }

    public function index()
    {
        $courseModel = new CourseModel();
        $courses = $courseModel
            ->join('users', 'users.id = courses.user_id')
            ->select('courses.*, users.name AS instructor_name')
            ->findAll();
        $courseTypes = SystemParameter::COURSE_TYPES;

        $users = model('UserModel')->where('role', 'admin')->findAll();

        return view('admin/course/list', [
            'courses' => $courses,
            'courseTypes' => $courseTypes,
            'users' => $users
        ]);
    }

    public function create()
    {
        $courseTypes = SystemParameter::COURSE_TYPES;

        return view('admin/course/create', [
            'courseTypes' => $courseTypes,
            'mode' => 'add',
            'course' => []
        ]);
    }

    public function attemptCreate()
    {
        $courseModel = new CourseModel();
        $db = Database::connect();
        if (!$courseModel->validate($this->request->getPost()))
            return redirect()->back()->withInput()->with('errors', $courseModel->getValidationMessages());

        $postData = $this->request->getPost();
        $postData['user_id'] = user_id();
        $postData['status'] = $this->request->getPost('status') ?? 0;

        if ($postData['course_type_id'] == SystemParameter::FORMAL_EDUCATION) {
            if ($this->request->getFile('document')->getError() == 4)
                return redirect()->back()->withInput()->with('error', 'Lütfen ders programı için dosya yükleyin');

            $documentFile = $this->request->getFile('document');

            if ($documentFile->getSize() > 1048576)
                return redirect()->back()->withInput()->with('error', 'Dosya boyutu en fazla 1MB olabilir');

            if (!$documentFile->isValid())
                return redirect()->back()->withInput()->with('error', $documentFile->getErrorString());

            $newName = $documentFile->getRandomName();
            if (!$documentFile->move(ROOTPATH . 'public/assets/uploads/document/', $newName))
                return redirect()->back()->withInput()->with('error', 'Ders programı yüklenemedi');

            $postData['document_name'] = $newName;
        }

        if ($this->request->getFile('course_image')->getError() != 4) {
            $courseImage = $this->request->getFile('course_image');

            if (!$courseImage->isValid())
                return redirect()->back()->withInput()->with('error', $courseImage->getErrorString());

            $newName = $courseImage->getRandomName();
            if (!$courseImage->move(ROOTPATH . 'public/assets/uploads/course/', $newName))
                return redirect()->back()->withInput()->with('error', 'Kurs görseli yüklenemedi');

            $postData['image_name'] = $newName;
        }

        $slug = slugify($postData['title']);
        $count = $courseModel->where('slug', $slug)->countAllResults(false);

        if ($count > 0)
            $slug .= '-' . ($count + 1);

        $postData['slug'] = $slug;

        $courseId = $courseModel->insert($postData);

        foreach ($postData['category_id'] as $id)
            $db->table('course_category')->insert([
                'course_id' => $courseId,
                'category_id' => $id
            ]);

        return redirect()->back()->with('message', 'Kurs başarıyla oluşturuldu');
    }

    public function edit($id)
    {
        $courseModel = new CourseModel();

        if ($course = $courseModel->find($id)) {
            $db = Database::connect();

            $courseTypes = SystemParameter::COURSE_TYPES;

            $categories = $db
                ->table('categories')
                ->join('course_category', 'course_category.category_id = categories.id')
                ->where('course_category.course_id', $id)
                ->select('categories.id AS category_id, categories.name AS category_name')
                ->get()
                ->getResultArray();

            return view('admin/course/create', [
                'course' => $course,
                'courseTypes' => $courseTypes,
                'categories' => $categories,
                'mode' => 'edit'
            ]);
        }
    }

    public function update()
    {
        if (!$this->request->getPost('course_id'))
            return redirect()->back()->withInput()->with('error', 'Kurs güncellenemedi');

        $courseModel = new CourseModel();

        if (!$courseModel->validate($this->request->getPost()))
            return redirect()->back()->withInput()->with('error', 'Kurs güncellenemedi');

        $courseId = $this->request->getPost('course_id');
        if (!$course = $courseModel->find($courseId))
            return redirect()->back()->withInput()->with('error', 'Kurs güncellenemedi');

        $postData = $this->request->getPost();
        $postData['status'] = $this->request->getPost('status') ?? 0;

        if ($postData['course_type_id'] == SystemParameter::FORMAL_EDUCATION) {
            if ($this->request->getFile('document')->getError() == 4)
                return redirect()->back()->withInput()->with('error', 'Lütfen ders programı için dosya yükleyin');

            $documentFile = $this->request->getFile('document');

            if ($documentFile->getSize() > 1048576)
                return redirect()->back()->withInput()->with('error', 'Dosya boyutu en fazla 1MB olabilir');

            if (!$documentFile->isValid())
                return redirect()->back()->withInput()->with('error', $documentFile->getErrorString());

            $newName = $documentFile->getRandomName();
            if (!$documentFile->move(ROOTPATH . 'public/assets/uploads/document/', $newName))
                return redirect()->back()->withInput()->with('error', 'Ders programı yüklenemedi');

            if ($course['document_name'])
                @unlink(ROOTPATH . 'public/assets/uploads/document/' . $course['document_name']);

            $postData['document_name'] = $newName;
        }

        if ($this->request->getFile('course_image')->getError() != 4) {
            $courseImage = $this->request->getFile('course_image');

            if (!$courseImage->isValid())
                return redirect()->back()->withInput()->with('error', $courseImage->getErrorString());

            $newName = $courseImage->getRandomName();
            if (!$courseImage->move(ROOTPATH . 'public/assets/uploads/course/', $newName))
                return redirect()->back()->withInput()->with('error', 'Kurs görseli yüklenemedi');

            @unlink(ROOTPATH . 'public/assets/uploads/course/' . $course['image_name']);
            $postData['image_name'] = $newName;
        }

        $slug = slugify($postData['title']);

        $count = model('CourseModel')
            ->where('slug', $slug)
            ->where('id !=', $courseId)
            ->countAllResults(false);

        if ($count > 0)
            $slug .= '-' . ($count + 1);

        $postData['slug'] = $slug;

        if (!$courseModel->update($courseId, $postData))
            return redirect()->back()->withInput()->with('error', 'Kurs güncellenemedi');

        $db = Database::connect();
        $db->table('course_category')->delete(['course_id' => $courseId]);

        $categoryIds = $this->request->getPost('category_id');

        foreach ($categoryIds as $categoryId)
            $db->table('course_category')->insert([
                'course_id' => $courseId,
                'category_id' => $categoryId
            ]);

        return redirect()->back()->with('message', 'Kurs başarıyla güncellendi');
    }

    public function delete($id)
    {
        $courseModel = new CourseModel();
        $courseModel->delete($id);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kurs başarıyla silindi'
        ]);
    }
}