<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewsType extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"            => ["type" => "int", "unsigned" => true, "auto_increment" => true],
            "journalist_id" => ["type" => "int", "unsigned" => true],
            "type_name"     => ["type" => "varchar", "constraint" => "30"],
            "created_at"    => ["type" => "datetime"],
            "updated_at"    => ["type" => "datetime"]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('journalist_id', 'journalist', 'id');
        $this->forge->createTable('news_type');

    }

    public function down()
    {
        $this->forge->dropForeignKey('news_type', 'journalist_id');
        $this->forge->dropTable('news_type');
    }
}
