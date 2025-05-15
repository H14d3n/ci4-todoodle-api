<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Todos extends Seeder
{
    public function run()
    {
        $todoNames = [
            ['title' => 'Buy groceries'],
            ['title' => 'Finish project report'],
            ['title' => 'Call the plumber'],
            ['title' => 'Schedule dentist appointment'],
            ['title' => 'Plan weekend trip'],
            ['title' => 'Read a book'],
            ['title' => 'Clean the house'],
            ['title' => 'Prepare presentation'],
            ['title' => 'Organize files'],
            ['title' => 'Exercise']
        ];

        $TodoModel = new \App\Models\TodoModel();

        foreach ($todoNames as $todo) {
            $data = [
                'title' => $todo['title'],
                'category_id' => rand(1, 10), // Make sure these IDs exist!
                'due_date' => date('Y-m-d', strtotime('+' . rand(1, 30) . ' days')),
                'description' => 'This is a description for ' . $todo['title'],
                'status' => rand(0, 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$TodoModel->insert($data)) {
                // Log or print error if insert fails
                print_r($TodoModel->errors());
            }
        }
    }
}
