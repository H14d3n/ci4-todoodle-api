<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class API extends BaseConfig
{

    public $check_api_key = TRUE;

    public $defaults = [
        'default_limit' => 100,
        'max_limit' => 100,
        'default_offset' => 0,
        'max_offset' => 1000,
        'default_order_by' => 'cID,asc',
        'allowed_order_fields' => [
            'cID',
            'title',
            'due_date',
            'category_id',
            'created_at',
            'name'
        ]
    ];
}