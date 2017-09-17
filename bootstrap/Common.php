<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Attacher;
use execut\alias\models\Log;
use execut\alias\Module;
use execut\yii\Bootstrap;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Common extends Bootstrap
{
    public $_defaultDepends = [
        'modules' => [
            'alias' => [
                'class' => Module::class,
            ],
        ],
    ];

    public function bootstrap($app) {
        parent::bootstrap($app);
//        $app->on('beforeRun', function () use ($app) {
            $models = $app->getModule('alias')->getModels();
            $this->attachToTables($models);
            $this->attachToModels($models);
//        });
    }

    /**
     * @param $models
     */
    protected function attachToTables($models): void
    {
        $tables = [];
        foreach ($models as $params) {
            $modelClass = $params['modelClass'];
            $tables[] = $modelClass::tableName();
        }

        $attacher = new Attacher([
            'tables' => $tables,
        ]);

        $attacher->safeUp();
    }

    protected function attachToModels($models) {
        $modelsClasses = ArrayHelper::map($models, 'modelClass', 'modelClass');
        foreach ($modelsClasses as $modelsClass) {
            Event::on($modelsClass,ActiveRecord::EVENT_BEFORE_UPDATE, function ($e) {
                $this->saveModelLog($e->sender);
            });
        }
    }

    /**
     * @param ActiveRecord $owner
     */
    public function saveModelLog($owner) {
        if (!$owner->isNewRecord) {
            $oldAlias = $owner->getOldAttribute('alias');
            $newAlias = $owner->getAttribute('alias');
            if ($oldAlias !== $newAlias) {
                Log::add($owner);
            }
        }
    }
}