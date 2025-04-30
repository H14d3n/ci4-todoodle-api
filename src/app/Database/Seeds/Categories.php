<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categoryNames = [
            ['name' => 'Urgent'],
            ['name' => 'Important'],
            ['name' => 'Unimportant'],
            ['name' => 'Completed'],
            ['name' => 'Cancelled'],
            ['name' => 'In Progress'],
            ['name' => 'Postponed'],
            ['name' => 'Waiting for Response'],
            ['name' => 'Reminder'],
            ['name' => 'Miscellaneous']
        ];

        $CategoryModel = model('App\Models\CategoryModel');
        
        foreach ($categoryNames as $category) {
            $CategoryModel->insert([
            'name' => $category['name'],
            'color_hex' => '#'.substr(md5(rand()), 0, 6), 
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
