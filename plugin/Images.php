<?php
/**
 */

namespace execut\alias\plugin;


use execut\files\models\File;
use execut\alias\Plugin;

class Images implements Plugin
{
    public function getModels()
    {
        return [
            [
                'modelClass' => File::class,
                'order' => 1,
                'pattern' => '<id:.*>-<dataAttribute:.*>.<extension:.*>',
                'route' => 'files/frontend',
            ],
        ];
    }
}