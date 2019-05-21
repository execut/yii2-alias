<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 4/18/19
 * Time: 2:02 PM
 */

namespace execut\alias\behaviors;


use yii\base\Behavior;

class QueryBehavior extends Behavior
{
    public $logsClass = null;
    public function byAlias($alias) {
        $class = $this->owner->modelClass;
        return $this->owner->andWhere([
            $class::tableName() . '.alias' => $alias,
        ]);
    }

    public function byAliasLogs($alias, $orWhere = false) {
        $logsClassName = $this->logsClass;
        $parts = explode('\\', $logsClassName);
        $relationName = lcfirst($parts[count($parts) - 1]);
        $where = [
            $logsClassName::tableName() . '.old_value' => $alias,
            'field' => 'alias',
        ];

        if ($orWhere) {
            $this->owner->orWhere($where);
        } else {
            $this->owner->andWhere($where);
        }

        return $this->owner->joinWith('logs', false);
    }

    public function byAliasReplaced($alias) {
        return $this->owner->andWhere(['REPLACE(' . $this->getTableName() . '.alias, \'-\', \'\')' => mb_strtolower($alias)]);
    }

    public function byAliasLogsReplaced($alias, $orWhere = false) {
        $logsClassName = $this->logsClass;
        $parts = explode('\\', $logsClassName);
        $relationName = lcfirst($parts[count($parts) - 1]);
        $where = [
            'REPLACE(' . $logsClassName::tableName() . '.old_value, \'-\', \'\')' => mb_strtolower($alias),
            'field' => 'alias',
        ];

        if ($orWhere) {
            $this->owner->orWhere($where);
        } else {
            $this->owner->andWhere($where);
        }

        return $this->owner->joinWith('logs', false);
    }
}