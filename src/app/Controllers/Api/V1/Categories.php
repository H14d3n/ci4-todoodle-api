<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class Categories extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format    = 'json';

    public function index()
    {
        // Get query parameters
        $limit  = $this->request->getGet('limit');
        $offset = $this->request->getGet('offset');
        $name   = $this->request->getGet('name'); // Example filter by name

        $builder = $this->model;

        if ($name !== null) {
            $builder = $builder->like('name', $name);
        }

        if ($limit !== null) {
            $builder = $builder->limit((int)$limit);
        }

        if ($offset !== null) {
            $builder = $builder->offset((int)$offset);
        }

        $categories = $builder->findAll();

        return $this->respond($categories);
    }

    public function show($id = null)
    {
        $category = $this->model->find($id);
        if ($category) {
            return $this->respond($category);
        } else {
            return $this->failNotFound('Category not found');
        }
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->failNotFound('Category not found');
        }
    }
}
