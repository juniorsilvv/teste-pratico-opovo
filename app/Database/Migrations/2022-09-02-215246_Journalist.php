<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Journalist extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"        => ["type" => "int", "unsigned" => true, "auto_increment" => true],
            "fist_name" => ["type" => "varchar", "constraint" => "50"],
            "last_name" => ["type" => "varchar", "constraint" => "50"],
            "email"     => ["type" => "varchar", "constraint" => "100"],
            "password"  => ["type" => "varchar", "constraint" => "100"],
            "created_at" => ["type" => "datetime"],
            "updated_at" => ["type" => "datetime"]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('journalist');
    }

    public function down()
    {
        $this->forge->dropTable('journalist');
    }
}
