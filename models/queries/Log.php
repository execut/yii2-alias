<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 10/10/18
 * Time: 11:57 AM
 */

namespace execut\alias\models\queries;


use yii\db\ActiveQuery;

class Log extends ActiveQuery
{
    public function byOldAlias($alias, $modelClass) {
        return $this->andWhere([
            'owner_table' => $modelClass::tableName(),
            'old_alias' => $alias,
        ]);
    }
}