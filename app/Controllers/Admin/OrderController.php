<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 9.09.2020
 * Time: 18:41
 */

namespace App\Controllers\Admin;


use App\Models\OrderModel;
use CodeIgniter\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $queryString = $this->request->uri->getQuery();
        return view('admin/order/index', compact('queryString'));
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;

        $orderModel = new OrderModel();
        $orders = $orderModel
            ->join('users', 'users.id = orders.user_id')
            ->select('orders.*, users.name AS customer_name')
            ->orderBy($sort['field'], $sort['sort']);

        if (isset($this->request->getPost('query')['customer_id'])) {
            $customerId = $this->request->getPost('query')['customer_id'];
            $orders = $orders->where('users.id', $customerId);
        } else if (isset($this->request->getPost('query')['order_code'])) {
            $orderCode = $this->request->getPost('query')['order_code'];
            if ($orderCode)
                $orders = $orders->where('orders.order_code', $orderCode);
        } else if (isset($this->request->getPost('query')['date_period'])) {
            $startDate = $this->request->getPost('query')['date_period']['start_date'] ?? null;
            $endDate = $this->request->getPost('query')['date_period']['end_date'] ?? null;

            if ($startDate && $endDate) {
                $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                $endDate = date('Y-m-d H:i:s', strtotime($endDate));

                $orders = $orders
                    ->where('orders.created_at >=', $startDate)
                    ->where('orders.created_at <', $endDate);
            }
        }

        $total = $orders->countAllResults(false);
        $pageSize = ceil($total / $limit);

        $orders = $orders->findAll($limit, $start);

        return $this->response->setJSON([
            'data' => $orders,
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

    public function orderDetail($id)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($id);

        $courses = [];

        if ($order) {
            $courseId = json_decode($order['course_id']);
            $courses = model('CourseModel')->select('title, price, discount_ratio')->find($courseId);
        }

        return $this->response->setJSON([
            'data' => $courses,
            'order_note' => $order['order_note']
        ])->setStatusCode(200);
    }
}