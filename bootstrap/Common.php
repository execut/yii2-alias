<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Attacher;
use execut\alias\models\Log;
use execut\alias\Module;
use execut\alias\UrlRule;
use execut\yii\Bootstrap;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Common extends Bootstrap
{
    public $isBootstrapI18n = true;
    public $_defaultDepends = [
        'modules' => [
            'alias' => [
                'class' => Module::class,
            ],
        ],
    ];

    /**
     * @param $app
     */
    protected function initUrlRules($app): void
    {
        $app->urlManager->addRules([
            'alias' => [
                'class' => UrlRule::class,
            ],
        ]);
    }
}