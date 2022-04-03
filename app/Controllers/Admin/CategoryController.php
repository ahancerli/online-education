<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 16.08.2020
 * Time: 18:06
 */

namespace App\Controllers\Admin;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        helper('string');
    }

    public function index()
    {
        return view('admin/category/index');
    }

    public function edit($id)
    {
        $categoryModel = new CategoryModel();
        if (!$category = $categoryModel->find($id))
            return redirect()->back();

        return view('admin/category/edit', [
            'category' => $category
        ]);
    }

    public function update()
    {
        if (!$categoryId = $this->request->getPost('category_id'))
            return redirect()->back()->with('error', 'Eksik veya hatalı parametre');

        $categoryModel = new CategoryModel();
        if (!$category = $categoryModel->find($categoryId))
            return redirect()->back()->with('error', 'Kategori bulunamadı');

        $postData = $this->request->getPost();

        if (!$categoryModel->validate($postData))
            return redirect()->back()->with('error', 'Eksik veya hatalı parametre');

        if ($this->request->getFile('category_image')->getError() != 4) {
            $categoryImage = $this->request->getFile('category_image');

            if (!$categoryImage->isValid())
                return redirect()->back()->withInput()->with('error', $categoryImage->getErrorString());

            $newName = $categoryImage->getRandomName();
            if (!$categoryImage->move(ROOTPATH . 'public/assets/uploads/category/', $newName))
                return redirect()->back()->withInput()->with('error', 'Profil fotoğrafı yüklenemedi');

            if ($category['image_name'])
                @unlink(ROOTPATH . 'public/assets/uploads/category/' . $category['image_name']);

            $postData['image_name'] = $newName;
        }

        $slug = slugify($postData['name']);

        $count = model('CategoryModel')
            ->where('slug', $slug)
            ->where('id != ', $categoryId)
            ->countAllResults(false);

        if ($count > 0)
            $slug .= '-' . ($count + 1);

        $postData['slug'] = $slug;

        if (!$categoryModel->update($categoryId, $postData))
            return redirect()->back()->with('error', 'Kategori güncellenemedi');

        return redirect()->back()->with('message', 'Kategori başarıyla güncellendi');
    }

    public function attemptCreate()
    {
        $categoryModel = new CategoryModel();

        $postData = $this->request->getPost();

        $slug = slugify($postData['name']);
        $count = $categoryModel->where('slug', $slug)->countAllResults(false);

        if ($count > 0)
            $slug .= '-' . ($count + 1);

        $postData['slug'] = $slug;

        if (!$categoryModel->validate($postData))
            return $this->response->setJSON([
                'success' => false,
                'message' => $categoryModel->getValidationMessages()
            ])->setStatusCode(422);

        if (!$categoryModel->insert($postData))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Kategori oluşturulamadı'
            ])->setStatusCode(409);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kategori başarıyla oluşturuldu'
        ])->setStatusCode(200);
    }

    public function moveCategory()
    {
        $rules = [
            'category_id' => 'required|numeric',
            'parent_id' => 'required|numeric'
        ];

        if (!$this->validate($rules))
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Eksik ya da hatalı parametre'
            ])->setStatusCode(422);

        $categoryModel = new CategoryModel();
        $categoryModel->update($this->request->getPost('category_id'), [
            'parent_id' => $this->request->getPost('parent_id')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Başarıyla güncellendi'
        ])->setStatusCode(200);
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
        if (!$categoryModel->delete($id))
            return $this->response->setJSON([
                'sucecss' => false,
                'message' => 'Kategori silinemedi'
            ])->setStatusCode(409);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Kategori başarıyla silindi'
        ])->setStatusCode(200);
    }

    public function getTree()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('status', true)->findAll();
        $categories = $this->getAllCategoryNames($categories);

        if (isset($categories[0]))
            $categories = $this->recursiveCategory(0, $categories);

        $categories = [
            'state' => [
                'opened' => true,
            ],
            'id' => 0,
            'text' => 'Ana Kategori',
            'children' => $categories
        ];

        return $this->response->setJSON($categories);
    }

    private function getAllCategoryNames($categories)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == 0)
                $result[0][$category['id']] = $category['name'];
            else {
                $result[$category['parent_id']][$category['id']] = $category['name'];
            }
        }

        return $result;
    }

    private function recursiveCategory($key, $categories)
    {
        $result = [];

        foreach ($categories[$key] as $id => $name) {
            $result[] = ['id' => $id, 'text' => $name];

            if (isset($categories[$id])) {
                $result[count($result) - 1]['children'] = $this->recursiveCategory($id, $categories);
            } else {
                $result[count($result) - 1]['icon'] = 'flaticon2-file';
            }
        }

        return $result;
    }
}