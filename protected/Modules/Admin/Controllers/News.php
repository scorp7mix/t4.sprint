<?php

namespace App\Modules\Admin\Controllers;

use T4\Core\Exception;
use T4\Core\MultiException;
use T4\Mvc\Controller;

class News
    extends Controller
{
    public function actionDefault()
    {
        $this->data->items = \App\Models\News::findAll();
    }
    
    public function actionEdit($id = null)
    {
        if (null !== $id) {
            $item = \App\Models\News::findByPK($id);
            if (empty($item)) {
                $this->app->flash->error = 'No news found for id ' . $id;
                $this->redirect('/admin/news');
            }
        } else {
            $item = new \App\Models\News();
        }

        $this->data->item = $item;
    }

    public function actionSave()
    {
        $post = $this->app->request->post;
        if (!empty($post->id)) {
            $item = \App\Models\News::findByPK($post->id);
            if (empty($item)) {
                $this->app->flash->error = 'Trying to edit not existed article ' . $post->id;
                $this->redirect('/admin/news');
            }
        } else {
            $item = new \App\Models\News();
        }
        
        try {
            $item->fill($post);
            if ($item->isNew()) {
                $item->published = (new \DateTime())->format('Y-m-d H:i:s');
            }
            $item->save();
            if ($this->app->request->isUploaded('image')) {
                $item->addImage('image');
            }
            $this->app->flash->message = 'Article #' . $item->getPk() . ' successfully saved';
        } catch (MultiException $e) {
            $this->app->flash->error = implode('<br>', $e->collect('message'));
        } catch (Exception $e) {
            $this->app->flash->error = $e->getMessage();
        }

        $this->redirect('/admin/news/');
    }

    public function actionDelete($id = null)
    {
        if (null !== $id) {
            $item = \App\Models\News::findByPK($id);
            if (empty($item)) {
                $this->app->flash->error = 'No news found for id ' . $id;
                $this->redirect('/admin/news');
            } else {
                $item->delete();
                $this->app->flash->message = 'Article #' . $id . ' successfully deleted';
            }
        } else {
            $this->app->flash->error = 'Can\'t delete object without Id';
        }

        $this->redirect('/admin/news');
    }
}