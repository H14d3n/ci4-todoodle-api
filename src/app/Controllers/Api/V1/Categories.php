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
        $cID      = $this->request->getGet('cID');  // Also allow cID as filter
        $order_by = $this->request->getGet('order_by'); // e.g. "name,asc" or "id,desc"

        $builder = $this->model;

        // Filter by name
        if ($name !== null) {
            $builder = $builder->like('name', $name);
        }

        // Mapping 
        $fieldMap = [
            'id'   => 'cID',   // API-Parameter "id" => "cID"
            'cID'  => 'cID',
            'name' => 'name'
        ];

        // Filter by id or cID
        if ($id !== null) {
            $builder = $builder->where('cID', (int)$id);
        } elseif ($cID !== null) {
            $builder = $builder->where('cID', (int)$cID);
        }

        // Sorting with whitelist
        if ($order_by !== null) {
            // Example: "name,asc" or "cID,desc"
            $parts = explode(',', $order_by);
            $field = $parts[0] ?? 'cID';
            $direction = strtolower($parts[1] ?? 'asc');
            if (!in_array($direction, ['asc', 'desc'])) {
                $direction = 'asc';
            }
            if (isset($fieldMap[$field])) {
                $builder = $builder->orderBy($fieldMap[$field], $direction);
            }
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
        $data = $this->request->getJSON(true) ?? $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        if (!$this->model->find($id)) {
            return $this->failNotFound('Category not found');
        }
        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();
        unset($data['cID']);
        if ($this->model->update($id, $data)) {
            return $this->respondUpdated($data);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        // Prüfen, ob noch Todos mit dieser Kategorie existieren
        $todoModel = new \App\Models\TodoModel();
        $todosCount = $todoModel->where('category_id', $id)->countAllResults();

        if ($todosCount > 0) {
            return $this->failResourceExists('Category cannot be deleted because there are still todos in it.');
        }

        if ($this->model->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->failNotFound('Category not found');
        }
    }
}
