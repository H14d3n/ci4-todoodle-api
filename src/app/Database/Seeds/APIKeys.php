<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class APIKeys extends Seeder
{
    public function run()
    {

        $api_keys_data = [
            [
                'api_key'       => 'iGadgwrYbDPULtDq2dNrCucRQpJjY2',
                'comments'      => 'Tizian API Key',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'api_key'       => 'QMeLxziZmYFbALKLrVnQf6KCFFXPHX',
                'comments'      => 'David API Key',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        ];
        
        // Init car model
        $APIKey_model = new \App\Models\APIKeys();

        // Insert & validate data
        foreach($api_keys_data as $index => $data) {

            if ($APIKey_model->insert($data) === false) {
                echo "Errors on api key on index ${index}:\n";
                print_r($APIKey_model->errors());
            }
            
        }
    }
}