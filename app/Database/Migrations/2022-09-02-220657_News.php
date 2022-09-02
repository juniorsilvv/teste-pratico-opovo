<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class News extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"            => ["type" => "int", "unsigned" => true, "auto_increment" => true],
            "journalist_id" => ["type" => "int", "unsigned" => true],
            "news_type_id"  => ["type" => "int", "unsigned" => true],
            "title"         => ["type" => "varchar", "constraint" => "100"],
            "description"   => ["type" => "text"],
            "news_body"     => ["type" => "text"],
            "featured_image" => ["type" => "varchar", "constraint" => "1000", "null" => true],
            "created_at"    => ["type" => "datetime"],
            "updated_at"    => ["type" => "datetime"]
        ]);
        $this->forge->addForeignKey('journalist_id', 'journalist', 'id');
        $this->forge->addForeignKey('news_type_id', 'news_type', 'id');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('news');
    }

    public function down()
    {
        $this->forge->dropForeignKey('news', 'journalist_id');
        $this->forge->dropForeignKey('news', 'news_type_id');
        $this->forge->dropTable('news');
    }
}
