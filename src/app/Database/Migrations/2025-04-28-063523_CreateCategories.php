<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategories extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `categories` (
            `cID` INT(11) NOT NULL AUTO_INCREMENT,
            `category_name` VARCHAR(255) NOT NULL,
            `category_color_hex` VARCHAR(7) NOT NULL,
            PRIMARY KEY (`id`)
        )
    }

    public function down()
    {
        //
    }
}
