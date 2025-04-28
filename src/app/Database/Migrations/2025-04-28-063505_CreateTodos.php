<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTodos extends Migration
{
    public function up()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `todos` (
            `tID` INT(11) NOT NULL AUTO_INCREMENT,
            `todo_title` VARCHAR(255) NOT NULL,
            `todo_category` INT(11) NOT NULL,
            `todo_due_date` DATE NOT NULL,
            `todo_description` TEXT NOT NULL,
            `todo_status` TINYINT(1) NOT NULL DEFAULT 0,
            `todo_created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `todo_updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`tID`)
        )");
    }

    public function down()
    {
        $this->forge->dropTable('todos');
    }
}
