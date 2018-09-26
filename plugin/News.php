<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/18/18
 * Time: 2:55 PM
 */

namespace execut\alias\plugin;


use execut\alias\Plugin;

class News implements Plugin
{
    public $moduleId = 'news';
    public $modelClass = \execut\news\models\News::class;
    public function getModels()
    {
        $modelClass = $this->modelClass;
        return [
            [
                'modelClass' => $modelClass,
                'route' => $this->moduleId . '/news/view',
                'pattern' => $this->moduleId . '/<id:.+>',
            ],
        ];
    }
}