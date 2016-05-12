<?php

namespace App\Models;

use T4\Core\Exception;
use T4\Core\Std;
use T4\Fs\Helpers;
use T4\Http\Uploader;

/**
 * Class Article
 * @package App\Models
 * 
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class Article
    extends Std
{
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
        $destPath = ROOT_PATH_PUBLIC . '/images/news/' . $this->id . $extension;
        Helpers::copyFile($sourcePath, $destPath);
        
        $this->image = '/images/news/' . $this->id . $extension;
        Helpers::removeFile($sourcePath);
    }
}