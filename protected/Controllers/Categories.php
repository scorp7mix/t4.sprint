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

        /** @var \T4\Core\Collection $products */
        $products = $this->data->item->products;
        foreach ($this->data->item->findAllChildren() as $child) {
            /** @var \App\Models\Category $child */
            $products = $products->merge($child->products);
        }
        $this->data->products = $products->sort(function (Product $p1, Product $p2) {
            return $p1->pk <=> $p2->pk;
        });
    }
}