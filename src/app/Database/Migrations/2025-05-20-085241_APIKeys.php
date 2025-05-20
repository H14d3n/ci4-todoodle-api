<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class APIKeys extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE api_keys
            (
            id INT(11) UNSIGNED AUTO_INCREMENT,
            api_key VARCHAR(255),
            is_active INT(1) DEFAULT 1,
            user_id INT(11),
            comments TEXT,
            created_at DATETIME,
            updated_at DATETIME,
            deleted_at DATETIME,
            PRIMARY KEY (id)
            );
        ");
    }

    public function down()
    {
        //
    }
}