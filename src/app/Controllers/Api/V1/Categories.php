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
        $limit    = $this->request->getGet('limit');
        $offset   = $this->request->getGet('offset');
        $name     = $this->request->getGet('name'); // Filter by name
        $id       = $this->request->getGet('id');   // Filter by id
        $order_by = $this->request->getGet('order_by'); // e.g. "name,asc" or "id,desc"

        $builder = $this->model;

        // Filter by name
        if ($name !== null) {
            $builder = $builder->like('name', $name);
        }

        // Filter by id
        if ($id !== null) {
            $builder = $builder->where('id', (int)$id);
        }

        // Sortierung
        if ($order_by !== null) {
            // Beispiel: order_by=name,asc oder order_by=id,desc
            $parts = explode(',', $order_by);
            $field = $parts[0] ?? 'id';
            $direction = strtolower($parts[1] ?? 'asc');
            if (!in_array($direction, ['asc', 'desc'])) {
                $direction = 'asc';
            }
            $builder = $builder->orderBy($field, $direction);
        }

        // Pagination
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
