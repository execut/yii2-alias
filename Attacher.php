<?php
/**
 */

namespace execut\alias;


use execut\yii\migration\Inverter;
use execut\yii\migration\Migration;

class Attacher extends \execut\yii\migration\Attacher
{
    public $tables = [];

    protected function getVariations () {
        return ['tables'];
    }

    public function initInverter(Inverter $i) {
        foreach ($this->tables as $table) {
            $isAttached = $this->db->getTableSchema($table)->getColumn('alias');
            if (!$isAttached) {
                $helper = new MigrationHelper([
                    'table' => $this->table($table)
                ]);
                $helper->attach();
            }
        }
    }
}