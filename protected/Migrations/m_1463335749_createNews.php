<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1463335749_createNews
    extends Migration
{

    public function up()
    {
        $this->createTable('news', [
            'title'     => ['type' => 'string'],
            'text'      => ['type' => 'text'],
            'published' => ['type' => 'datetime'],
            'image'     => ['type' => 'string'],
        ], [
            'published_idx' => ['columns' => ['published']],
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }

}