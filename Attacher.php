<?php
/**
 */

namespace execut\alias;


use execut\yii\migration\Inverter;
use execut\yii\migration\Migration;
use yii\base\Exception;

class Attacher extends \execut\yii\migration\Attacher
{
    public $tables = [];

    protected function getVariations () {
        return ['tables'];
    }

    public function initInverter(Inverter $i) {
        foreach ($this->tables as $table) {
            $tableSchema = $this->db->getTableSchema($table);
            if (!$tableSchema) {
                throw new Exception('Not found table ' . $table);
            }

            $isAttached = $tableSchema->getColumn('alias');
            if (!$isAttached) {
                $helper = new MigrationHelper([
                    'table' => $this->table($table)
                ]);
                $helper->attach();
            }
        }
    }
}