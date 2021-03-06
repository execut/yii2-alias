<?php
/**
 */

namespace execut\alias;


use execut\alias\models\Log;
use execut\dependencies\PluginBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;
use yii\web\Application;

class Module extends \yii\base\Module implements Plugin
{
    public $models = [];
    public function behaviors()
    {
        return [
            [
                'class' => PluginBehavior::class,
                'pluginInterface' => Plugin::class,
            ],
        ];
    }

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function getModels() {
        $models = array_merge($this->getPluginsResults(__FUNCTION__), $this->models);
        uasort($models, function ($model1, $model2) {
            if (empty($model1['order'])) {
                return false;
            } else if (empty($model2['order'])) {
                return true;
            } else {
                return $model1['order'] >= $model2['order'];
            }
        });

        return $models;
    }
}