<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 15.09.2020
 * Time: 11:48
 */

namespace App\Controllers\Admin;


use CodeIgniter\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin/customer/index');
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;

        $customers = model('UserModel')
            ->join('orders', 'orders.user_id = users.id', 'LEFT')
            ->where('role', 'customer')
            ->select('users.*, COUNT(orders.id) AS order_count')
            ->orderBy($sort['field'], $sort['sort']);

        if (isset($this->request->getPost('query')['search_value'])) {
            $searchValue = $this->request->getPost('query')['search_value'];
            $customers = $customers->like('name', $searchValue)->orLike('email', $searchValue);
        } else {
            if (isset($this->request->getPost('query')['date_period'])) {
                $startDate = $this->request->getPost('query')['date_period']['start_date'] ?? null;
                $endDate = $this->request->getPost('query')['date_period']['end_date'] ?? null;

                if ($startDate && $endDate) {
                    $startDate = date('Y-m-d H:i:s', strtotime($startDate));
                    $endDate = date('Y-m-d H:i:s', strtotime($endDate));

                    $customers = $customers
                        ->where('users.created_at >=', $startDate)
                        ->where('users.created_at <', $endDate);
                }
            }
        }

        $total = $customers->countAllResults(false);
        $pageSize = ceil($total / $limit);

        $customers = $customers->findAll($limit, $start);

        $customers = array_map(function ($customer) {
            $createdAt = $customer->created_at->toDateTimeString();
            $updatedAt = $customer->updated_at->toDateTimeString();

            $customer = $customer->toArray();
            $customer['created_at'] = $createdAt;
            $customer['updated_at'] = $updatedAt;

            return $customer;
        }, $customers);

        return $this->response->setJSON([
            'data' => $customers,
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