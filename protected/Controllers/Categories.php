<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use T4\Mvc\Controller;

class Categories
    extends Controller
{
    public function actionOne(int $id)
    {
        $this->data->item = Category::findByPK($id);

        $this->data->products = $this->data->item->findChildProducts();
    }
}