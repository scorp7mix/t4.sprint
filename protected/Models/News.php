<?php

namespace App\Models;

use T4\Core\Config;

/**
 * Class News
 * @package App\Models
 */
class News
    extends Config
{
    const PATH = ROOT_PATH_PROTECTED . '/Data/news.php';

    /**
     * @return array
     */
    public static function findAll()
    {
        return (new self(self::PATH))->sort(true)->toArray();
    }

    /**
     * @param int $id
     * @return Article|null
     */
    public static function findOne(int $id)
    {
        $news = new self(self::PATH);
        
        foreach ($news as $data) {
            if ($data->id === $id) {
                $article = new Article($data->toArray());
                break;
            }
        }

        return $article ?? null;
    }

    protected function sort($reverse = false)
    {
        $news = $this->toArray();

        usort($news, function ($a1, $a2) use ($reverse) {
            if (true === $reverse) {
                return $a2['id'] <=> $a1['id'];
            } else {
                return $a1['id'] <=> $a2['id'];
            }
        });

        $this->__data = [];
        $this->fromArray($news);
        return $this;
    }

    /**
     * @return Article|null
     */
    public static function findLast()
    {
        $news = (new self(self::PATH))->sort(true);

        if ($news->count() > 0) {
            $last = new Article($news[0]->toArray());
        }

        return $last ?? null;
    }

    /**
     * @param Article $article
     */
    public static function addArticle(Article $article)
    {
        $news = (new self(self::PATH))->sort(true);

        $lastId = 0;
        if ($news->count() > 0) {
            $lastId = $news[0]->id;
        }
        
        $article->id = ++$lastId;
        $article->addImage('image');

        $news->append($article->toArray());
        $news->save();
    }
}