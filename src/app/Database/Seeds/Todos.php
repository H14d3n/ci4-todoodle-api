<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Todos extends Seeder
{
    public function run()
    {
        $todoNames = [
            ['todo_title' => 'Buy groceries'],
            ['todo_title' => 'Finish project report'],
            ['todo_title' => 'Call the plumber'],
            ['todo_title' => 'Schedule dentist appointment'],
            ['todo_title' => 'Plan weekend trip'],
            ['todo_title' => 'Read a book'],
            ['todo_title' => 'Clean the house'],
            ['todo_title' => 'Prepare presentation'],
            ['todo_title' => 'Organize files'],
            ['todo_title' => 'Exercise']
        ];

        $TodoModel = model('App\Models\TodoModel');
        
        foreach ($todoNames as $todo) {
            $TodoModel->insert([
            'todo_title' => $todo['todo_title'],
            'todo_category' => rand(1, 10), // Random category ID between 1 and 10
            'todo_due_date' => date('Y-m-d', strtotime('+'.rand(1, 30).' days')), 
            'todo_description' => 'This is a description for '.$todo['todo_title'],
            'todo_status' => rand(0, 1), 
            'todo_created_at' => date('Y-m-d H:i:s'),
            'todo_updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
