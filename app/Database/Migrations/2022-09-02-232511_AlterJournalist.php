<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterJournalist extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('journalist',[
            "fist_name" => [
                "name" => "first_name", 
                "type" => "varchar",
                "constraint" => "50"
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
