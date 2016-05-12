<?php

namespace App\Controllers;


use App\Models\Article;
use T4\Core\Exception;
use T4\Mvc\Controller;

class News
    extends Controller
{
    public function actionDefault()
    {
        $this->data->news = \App\Models\News::findAll();
    }

    public function actionOne($id)
    {
        $this->data->article = \App\Models\News::findOne((int)$id);
    }

    public function actionLast()
    {
        $this->data->article = \App\Models\News::findLast();
    }

    public function actionForm()
    {

    }

    public function actionAdd(Article $data)
    {
        try {
            \App\Models\News::addArticle($data);
        } catch (Exception $e) {
            $this->app->flash->error = $e->getMessage();
        }

        $this->redirect('/news');
    }
}