<?php
/**
 */

namespace execut\alias\crudFields;

use execut\alias\Attacher;
use execut\alias\models\Log;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;
use yii\helpers\Inflector;

class Plugin extends \execut\crudFields\Plugin
{
    public $transliteratedAttribute = null;
    public $isUnique = true;
    public function getFields() {
        return [
            [
                'attribute' => 'alias',
                'module' => 'alias',
            ],
        ];
    }

    public function rules() {
        $rules = [
            'aliasDefaultValue' => ['alias', 'default', 'skipOnEmpty' => false, 'except' => 'grid', 'value' => function () {
                return $this->getDefaultValue();
            }],
            'aliasRequired' => ['alias', 'required', 'skipOnEmpty' => false, 'except' => 'grid'],
        ];

        if ($this->isUnique) {
            $rules['aliasUniqueValue'] = ['alias', 'unique', 'skipOnEmpty' => false, 'except' => 'grid'];
        }

        return $rules;
    }

    protected function getDefaultValue() {
        if ($transliteratedAttribute = $this->transliteratedAttribute) {
            return preg_replace('/[^a-z0-9\-]*/', '', preg_replace('/[ -]+/', '-', strtolower(Inflector::transliterate($this->owner->$transliteratedAttribute))));
        }
    }

    protected static $isAttached = false;
    public function attach() {
        if (self::$isAttached) {
            return;
        }

        self::$isAttached = true;
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