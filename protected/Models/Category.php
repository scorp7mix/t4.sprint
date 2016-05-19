<?php

namespace App\Models;

use T4\Orm\Model;

/**
 * Class Category
 * @package App\Models
 *
 * @property string $title
 *
 * @property \T4\Core\Collection|\App\Models\Product[] $products
 */
class Category
    extends Model
{
    protected static $schema = [
        'table'   => 'categories',
        'columns' => [
            'title' => ['type' => 'string'],
        ],
        'relations' => [
            'products' => ['type' => self::HAS_MANY, 'model' => Product::class]
        ],
    ];

    static protected $extensions = ['tree'];
}