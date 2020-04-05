<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Module;
use execut\alias\UrlRule;
use execut\yii\Bootstrap;

class Frontend extends Web
{
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        \yii::$app->urlManager->enablePrettyUrl = true;
        $this->initUrlRules($app);
    }
}