<?php

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class HomeController extends Controller
{
    public function index()
    {
        $startDate = Time::now()->subDays(7);
        $endDate = Time::now();

        $orderModel = new OrderModel();

        $orderReport = $orderModel
            ->where('created_at >=', $startDate)
            ->where('created_at <', $endDate)
            ->selectCount('*', 'order_count')
            ->selectSum('amount', 'total_income')
            ->first();

        $weeklyCourseCount = model('CourseModel')
            ->where('created_at >=', $startDate)
            ->where('created_at <', $endDate)
            ->countAllResults();

        return view('admin/home', compact('orderReport', 'weeklyCourseCount'));
    }

    public function orderCountByMonth()
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');

        $monthNames = [];

        $startDate = Time::now()->subMonths(10);
        $endDate = Time::now();

        while ($startDate->isBefore($endDate)) {
            $key = strftime('%b', $startDate->getTimestamp());
            $monthNames[$key] = 0;
            $startDate = $startDate->addMonths(1);
        }

        $startDate = Time::now()->subMonths(10);

        $orderModel = new OrderModel();
        $orders = $orderModel
            ->select('COUNT(*) AS order_count, created_at')
            ->where('created_at >=', $startDate)
            ->where('created_at <', $endDate)
            ->groupBy('MONTH(created_at)')
            ->findAll();

        foreach ($orders as $order) {
            $key = strftime('%b', strtotime($order['created_at']));
            if (isset($monthNames[$key]))
                $monthNames[$key] = $order['order_count'];
        }

        return $this->response->setJSON($monthNames);
    }

    public function soldCourseCountByMonth()
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');

        $monthNames = [];

        $startDate = Time::now()->subMonths(10);
        $endDate = Time::now();

        while ($startDate->isBefore($endDate)) {
            $key = strftime('%b', $startDate->getTimestamp());
            $monthNames[$key] = 0;
            $startDate = $startDate->addMonths(1);
        }

        $startDate = Time::now()->subMonths(10);

        $orderModel = new OrderModel();
        $orders = $orderModel
            ->selectSum('JSON_LENGTH(course_id)', 'sold_course_count')
            ->select('created_at')
            ->where('created_at >=', $startDate)
            ->where('created_at <', $endDate)
            ->groupBy('MONTH(created_at)')
            ->findAll();

        foreach ($orders as $order) {
            $key = strftime('%b', strtotime($order['created_at']));
            if (isset($monthNames[$key]))
                $monthNames[$key] = $order['sold_course_count'];
        }

        return $this->response->setJSON($monthNames);
    }

    public function totalIncomeByMonth()
    {
        setlocale(LC_ALL, 'tr_TR.UTF-8');

        $monthNames = [];

        $startDate = Time::now()->subMonths(10);
        $endDate = Time::now();

        while ($startDate->isBefore($endDate)) {
            $key = strftime('%b', $startDate->getTimestamp());
            $monthNames[$key] = 0;
            $startDate = $startDate->addMonths(1);
        }

        $startDate = Time::now()->subMonths(10);

        $orderModel = new OrderModel();
        $orders = $orderModel
            ->selectSum('amount', 'total_income')
            ->select('created_at')
            ->where('created_at >=', $startDate)
            ->where('created_at <', $endDate)
            ->groupBy('MONTH(created_at)')
            ->findAll();

        foreach ($orders as $order) {
            $key = strftime('%b', strtotime($order['created_at']));
            if (isset($monthNames[$key]))
                $monthNames[$key] = $order['order_count'];
        }

        return $this->response->setJSON($monthNames);
    }

    public function bestSellingCourses()
    {
        $result = model('EnrollmentModel')
            ->select('course_id, COUNT(course_id) AS occurence, courses.title AS course_name')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->groupBy('course_id')
            ->orderBy('occurence', 'DESC')
            ->limit(3)
            ->findAll();

        return $this->response->setJSON([
            'labels' => array_column($result, 'course_name'),
            'values' => array_column($result, 'occurence')
        ]);
    }
}