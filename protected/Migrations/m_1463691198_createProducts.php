<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1463691198_createProducts
    extends Migration
{

    public function up()
    {
        $this->createTable('products', [
            'title'         => ['type' => 'string'],
            'price'         => ['type' => 'float'],
            '__category_id' => ['type' => 'link'],
        ], [
            'price_idx' => ['columns' => ['price']]
        ]);
    }

    public function down()
    {
        $this->dropTable('products');
    }

}