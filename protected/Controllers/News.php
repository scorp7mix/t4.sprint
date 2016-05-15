<?php

namespace App\Controllers;


use T4\Mvc\Controller;

class News
    extends Controller
{
    public function actionDefault()
    {
        $this->data->news = \App\Models\News::findAll([
            'order' => 'published DESC'
        ]);
    }

    public function actionOne($id)
    {
        $this->data->article = \App\Models\News::findByPK($id);
    }

    public function actionLast()
    {
        $this->data->article = \App\Models\News::find([
            'order' => 'published DESC',
        ]);
    }
}