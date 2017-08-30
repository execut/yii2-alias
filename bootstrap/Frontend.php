<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Module;
use execut\alias\UrlRule;
use execut\yii\Bootstrap;

class Frontend extends Bootstrap
{
    public function getDefaultDepends()
    {
        return [
            'modules' => [
                'alias' => [
                    'class' => Module::class,
                ],
            ],
        ];
    }

    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $app->urlManager->addRules([
            [
                'class' => UrlRule::class,
            ],
        ]);
    }
}