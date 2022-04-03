<?php

namespace App\Controllers\Front;

use App\Models\CourseModel;
use CodeIgniter\Controller;
use Config\Services;

class CategoryController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = 1;

        if ($this->request->getGet('page'))
            if (is_numeric($this->request->getGet('page')))
                $page = $this->request->getGet('page');

        $courseModel = new CourseModel();

        $courses = $courseModel
            ->selectAvg('ratings.point', 'avg_point')
            ->selectCount('comments.id', 'comment_count')
            ->selectCount('enrollments.id', 'user_count')
            ->select('courses.*, users.name AS instructor_name')
            ->join('users', 'users.id = courses.user_id')
            ->join('course_category', 'course_category.course_id = courses.id', 'LEFT')
            ->join('comments', 'comments.course_id = courses.id', 'LEFT')
            ->join('ratings', 'ratings.course_id = courses.id', 'LEFT')
            ->join('enrollments', 'enrollments.course_id = courses.id', 'LEFT')
            ->groupBy('courses.id');

        $instructorId = [];
        $categoryId = [];
        $point = [];
        $searchQuery = null;
        $sort = $this->request->getGet('sort') ?? 'created_at|DESC';

        if ($this->request->getGet('instructor_id'))
            if (is_array($this->request->getGet('instructor_id'))) {
                $instructorId = $this->request->getGet('instructor_id');
                $courses = $courses->whereIn('courses.user_id', $instructorId);
            }

        if ($this->request->getGet('category_id'))
            if (is_array($this->request->getGet('category_id'))) {
                $categoryId = $this->request->getGet('category_id');
                $courses = $courses->whereIn('course_category.category_id', $categoryId);
            }

        if ($this->request->getGet('point'))
            if (is_array($this->request->getGet('point'))) {
                $point = $this->request->getGet('point');
                foreach ($point as $value)
                    $courses = $courses->orHaving('avg_point >=', intval($value));
            }

        if ($this->request->getGet('search_query')) {
            $searchQuery = $this->request->getGet('search_query');
            $courses = $courses->like('courses.title', $searchQuery);
        }

        if (is_string($sort)) {
            $sortData = explode('|', $sort);
            $courses = $courses->orderBy('courses.' . $sortData[0], $sortData[1]);
        }

        $total = $courses->countAll(false);

        //$courses = $courses->paginate($perPage, 'default', $page);
        $courses = $courses->findAll($perPage, $perPage * ($page - 1));

        $categories = model('CategoryModel')
            ->join('course_category', 'course_category.category_id = categories.id')
            ->groupBy('categories.id')
            ->select('categories.id, categories.name, COUNT(course_category.course_id) AS course_count')
            ->where('categories.status', true)
            ->orderBy('categories.sort_order', 'ASC')
            ->findAll();

        $instructors = model('UserModel')
            ->join('courses', 'courses.user_id = users.id')
            ->where('users.role', 'admin')
            ->groupBy('users.id')
            ->select('users.id, users.name, COUNT(courses.id) AS course_count')
            ->findAll();

        $pager = Services::pager();

        $pageTitle = 'Eğitim Kataloğu';

        return view('front/category', compact(
            'categories', 'courses', 'instructors', 'pager', 'total', 'page', 'perPage',
            'instructorId', 'categoryId', 'searchQuery', 'sort', 'point', 'pageTitle'
        ));
    }
}