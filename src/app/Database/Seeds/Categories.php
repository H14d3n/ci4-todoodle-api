<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        $categoryNames = [
            ['category_name' => 'Urgent'],
            ['category_name' => 'Important'],
            ['category_name' => 'Unimportant'],
            ['category_name' => 'Completed'],
            ['category_name' => 'Cancelled'],
            ['category_name' => 'In Progress'],
            ['category_name' => 'Postponed'],
            ['category_name' => 'Waiting for Response'],
            ['category_name' => 'Reminder'],
            ['category_name' => 'Miscellaneous']
        ];

        $CategoryModel = model('App\Models\CategoryModel');
        
        foreach ($categoryNames as $category) {
            $CategoryModel->insert([
            'category_name' => $category['category_name'],
            'category_color_hex' => '#'.substr(md5(rand()), 0, 6), 
            'category_created_at' => date('Y-m-d H:i:s'),
            'category_updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
