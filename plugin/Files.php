<?php
/**
 */

namespace execut\alias\plugin;


use execut\alias\Plugin;
use execut\files\models\File;

class Files implements Plugin
{
    public function getModels()
    {
        return [
            [
                'modelClass' => File::class,
                'order' => 0,
                'pattern' => '<id:.*>.<extension:.*>',
                'route' => 'files/frontend',
            ],
        ];
    }
}