<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 22.08.2020
 * Time: 21:38
 */

namespace App\Controllers\Admin;


use App\Models\ContentsModel;
use CodeIgniter\Controller;



class ContentsController extends Controller
{
    public function index()
    {
        return view('admin/content/index');
    }

    public function list()
    {
        $sort = $this->request->getPost('sort') ?? ['field' => 'created_at', 'sort' => 'desc'];
        $page = $this->request->getPost('pagination')['page'] ?? 1;
        $limit = $this->request->getPost('pagination')['perpage'] ?? 20;
        $start = ($page - 1) * $limit;


        $contentModel = new ContentsModel();
        $content = $contentModel
            ->select('contents.*')
            ->orderBy($sort['field'], $sort['sort'])
            ->findAll($limit, $start);

        $total = $contentModel->countAll();
        $pageSize = ceil($total / $limit);

        return $this->response->setJSON([
            'data'=>$content,
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
            'id' => 'required',
            'status' => 'required'
        ];

        if (!$this->validate($rules))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Eksik veya hatalı parametre'
            ])->setStatusCode(422);

        $contentModel = new ContentsModel();
        $contentModel->update($this->request->getPost('id'), [
            'status' => $this->request->getPost('status')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Başarıyla güncellendi'
        ])->setStatusCode(200);
    }

    public function delete($id)
    {
        $contentModel = new ContentsModel();
        if (!$contentModel->delete($id))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'İçerik silinemedi'
            ])->setStatusCode(409);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'İçerik başarıyla silindi'
        ])->setStatusCode(200);
    }

    public function create()
     {
         return view('admin/content/create',[
             'mode'=>'add',
             'content'=>[]
         ]);
     }

    public function attemptCreate()
    {
        $contentModel = new ContentsModel();
        $postData = $this->request->getPost();
        $postData['status'] = $this->request->getPost('status') ?? 0;

        if (!$contentModel->validate($postData))
            return redirect()->back()->withInput()->with('errors', $contentModel->getValidationMessages());

        $contentModel->insert($postData);

        return redirect()->back()->with('message', 'İçerik başarıyla oluşturuldu');
    }

    public function edit($id)
    {
        $contentModel = new ContentsModel();

        if ($content = $contentModel->find($id)) {
            return view('admin/content/create', [
                'content' => $content,
                'mode' => 'edit'
            ]);
        }
    }

    public function update()
    {

        if (!$this->request->getPost('content_id'))
            return redirect()->back()->withInput()->with('error', 'İçerik güncellenemedi');

        $contentModel = new ContentsModel();

        if (!$contentModel->validate($this->request->getPost()))
            return redirect()->back()->withInput()->with('error', 'İçerik güncellenemedi');

        $content_id = $this->request->getPost('content_id');
        if (!$content = $contentModel->find($content_id))
            return redirect()->back()->withInput()->with('error', 'İçerik güncellenemedi');

        $postData = $this->request->getPost();
        $postData['status'] = $this->request->getPost('status') ?? 0;

        if (!$contentModel->update($content_id, $postData))
            return redirect()->back()->withInput()->with('error', 'İçerik güncellenemedi');
        return redirect()->back()->with('message', 'İçerik başarıyla güncellendi');
    }



}