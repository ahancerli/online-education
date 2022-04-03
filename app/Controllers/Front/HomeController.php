<?php

namespace App\Controllers\Front;


use App\Models\CategoryModel;
use App\Models\CourseModel;
use CodeIgniter\Controller;


class HomeController extends Controller
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel
            ->where('status', true)
            ->where('parent_id', 0)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $courseModel = new CourseModel();

        foreach ($categories as $index => $category) {
            $courses = $courseModel
                ->join('users', 'users.id = courses.user_id')
                ->join('course_category', 'course_category.course_id = courses.id', 'LEFT')
                ->join('comments', 'comments.course_id = courses.id', 'LEFT')
                ->join('ratings', 'ratings.course_id = courses.id', 'LEFT')
                ->join('enrollments', 'enrollments.course_id = courses.id', 'LEFT')
                ->where('course_category.category_id', $category['id'])
                ->groupBy('courses.id')
                ->selectAvg('ratings.point', 'avg_point')
                ->selectCount('enrollments.id', 'user_count')
                ->select('courses.*, users.name AS instructor_name, COUNT(comments.id) AS comment_count')
                ->findAll();

            $categories[$index]['courses'] = $courses;
        }

        return view('front/home', compact('categories'));
    }
}