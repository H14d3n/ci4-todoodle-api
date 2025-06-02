<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class Todos extends ResourceController
{
    protected $modelName = 'App\Models\TodoModel';
    protected $format    = 'json';

    public function index()
    {
        // Query-Parameter holen
        $limit      = $this->request->getGet('limit');
        $offset     = $this->request->getGet('offset');
        $title      = $this->request->getGet('title'); // Filter by title
        $id         = $this->request->getGet('id');    // Filter by id
        $categoryId = $this->request->getGet('category_id'); // Filter by category_id
        $order_by   = $this->request->getGet('order_by'); // z.B. "due_date,asc"

        $builder = $this->model;

        // Filter by title
        if ($title !== null) {
            $builder = $builder->like('title', $title);
        }

        // Filter by id
        if ($id !== null) {
            $builder = $builder->where('id', (int)$id);
        }

        // Filter by category_id
        if ($categoryId !== null) {
            $builder = $builder->where('category_id', (int)$categoryId);
        }

        // Sortierung mit Whitelist
        $allowedOrderFields = ['id', 'title', 'due_date', 'category_id', 'created_at'];
        if ($order_by !== null) {
            $parts = explode(',', $order_by);
            $field = $parts[0] ?? 'id';
            $direction = strtolower($parts[1] ?? 'asc');
            if (!in_array($direction, ['asc', 'desc'])) {
                $direction = 'asc';
            }
            if (in_array($field, $allowedOrderFields)) {
                $builder = $builder->orderBy($field, $direction);
            }
        }

        // Pagination
        if ($limit !== null) {
            $builder = $builder->limit((int)$limit);
        }
        if ($offset !== null) {
            $builder = $builder->offset((int)$offset);
        }

        $todos = $builder->findAll();

        return $this->respond($todos);
    }

    public function show($id = null)
    {
        $todo = $this->model->find($id);
        if ($todo) {
            return $this->respond($todo);
        } else {
            return $this->failNotFound('Todo not found');
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
            return $this->failNotFound('Todo not found');
        }
    }
}
