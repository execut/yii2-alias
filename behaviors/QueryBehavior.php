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
    public function byAlias($alias) {
        $class = $this->owner->modelClass;
        return $this->owner->andWhere([
            $class::tableName() . '.alias' => $alias,
        ]);
    }
}