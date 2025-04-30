<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategories extends Migration
{
    public function up()
    {
        $this->db->query("
        CREATE TABLE IF NOT EXISTS `categories` (
            `cID` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(100) NOT NULL,
            `color_hex` CHAR(7) DEFAULT '#ffffff',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`cID`)
        )
    ");
    
    $this->db->query("
        CREATE TABLE IF NOT EXISTS `todos` (
                `tID` INT(11) NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(255) NOT NULL,
                `category_id` INT(11),
                `due_date` DATE DEFAULT NULL,
                `description` TEXT,
                `status` TINYINT(1) NOT NULL DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`tID`),
                FOREIGN KEY (`category_id`) REFERENCES `categories`(`cID`) ON DELETE SET NULL ON UPDATE CASCADE
            )
        ");
}

    public function down()
    {
        $this->forge->dropTable(tableName: 'todos');
        $this->forge->dropTable(tableName: 'categories');
    }
}
