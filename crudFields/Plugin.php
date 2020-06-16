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
    public $isRequired = true;
    protected function _getFields() {
        return [
            'alias' => [
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
        ];
        if ($this->isRequired) {
            if (is_callable($this->isRequired)) {
                $when = $this->isRequired;
            } else {
                $when = null;
            }

            $rules['aliasRequired'] = ['alias', 'required', 'skipOnEmpty' => false, 'except' => 'grid', 'when' => $when];
        }

        if ($this->isUnique) {
            $rules['aliasUniqueValue'] = ['alias', 'unique', 'skipOnEmpty' => true, 'except' => 'grid'];
        }

        return $rules;
    }

    protected function getDefaultValue() {
        if ($transliteratedAttribute = $this->transliteratedAttribute) {
            return preg_replace('/[^a-z0-9\-]*/', '', preg_replace('/[ -]+/', '-', strtolower(Inflector::transliterate($this->owner->$transliteratedAttribute))));
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