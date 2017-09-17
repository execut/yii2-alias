<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Module;
use execut\alias\UrlRule;
use execut\yii\Bootstrap;

class Frontend extends Common
{
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        \yii::$app->urlManager->enablePrettyUrl = true;
        $app->urlManager->addRules([
            'alias' => [
                'class' => UrlRule::class,
            ],
        ]);
    }
}