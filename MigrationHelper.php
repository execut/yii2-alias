<?php
/**
 */

namespace execut\alias;


use execut\yii\migration\Table;
use yii\base\Object;

class MigrationHelper extends Object
{
    /**
     * @var Table
     */
    public $table = null;
    public function attach() {
        $this->table->addColumns([
            'alias' => $this->table->migration->string(),
        ]);
    }
}