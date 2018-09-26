<?php
/**
 */

namespace execut\alias\plugin;


use execut\alias\Plugin;
use execut\pages\models\Page;

class Pages implements Plugin
{
    public $modelClass = Page::class;
    public function getModels()
    {
        return [
            [
                'modelClass' => $this->modelClass,
                'order' => 100,
                'route' => 'pages/frontend/index'
            ],
        ];
    }
}