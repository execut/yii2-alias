<?php
/**
 */

namespace execut\alias\crudFields;

use execut\alias\Attacher;
use execut\alias\models\Log;
use yii\base\Event;
use yii\db\ActiveRecord;

class Plugin extends \execut\crudFields\Plugin
{
    public function getFields() {
        return [
            [
                'attribute' => 'alias',
                'module' => 'alias',
                'required' => true,
            ],
        ];
    }

    public function rules() {
        return [
            ['alias', 'unique', 'skipOnEmpty' => false, 'except' => 'grid'],
        ];
    }

    public function attach() {
        $attacher = new Attacher([
            'tables' => [
                $this->owner->tableName()
            ],
        ]);

        $attacher->safeUp();
        Event::on($this->owner->className(), ActiveRecord::EVENT_BEFORE_UPDATE, function ($e) {
            $this->saveModelLog($e->sender);
        });
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