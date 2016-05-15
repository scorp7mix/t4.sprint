<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Fs\Helpers;
use T4\Http\Uploader;
use T4\Orm\Model;

/**
 * Class News
 * @package App\Models
 *
 * @property string $title
 * @property string $text
 * @property string $published
 * @property string $image
 */
class News
    extends Model
{
    protected static $schema = [
        'table'   => 'news',
        'columns' => [
            'title'     => ['type' => 'string'],
            'text'      => ['type' => 'string'],
            'published' => ['type' => 'datetime'],
            'image'     => ['type' => 'string'],
        ],
    ];

    /**
     * @param string $field
     * @throws Exception
     */
    public function addImage(string $field)
    {
        $uploader = new Uploader($field);
        $uploader->setPath('/tmp');

        $source = $uploader();
        if (false === $source) {
            throw new Exception('Error while loading file');
        }

        $sourcePath = ROOT_PATH_PUBLIC . $source;
        $extension = '.' . pathinfo($sourcePath, PATHINFO_EXTENSION);
        $destPath = ROOT_PATH_PUBLIC . '/images/news/' . $this->getPk() . $extension;
        Helpers::copyFile($sourcePath, $destPath);

        $this->image = '/images/news/' . $this->getPk() . $extension;
        $this->save();
        
        Helpers::removeFile($sourcePath);
    }

}