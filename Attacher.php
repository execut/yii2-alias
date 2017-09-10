<?php
/**
 */

namespace execut\alias;


use execut\yii\migration\Inverter;
use execut\yii\migration\Migration;

class Attacher extends Migration
{
    public $tables = [];
    public function initInverter(Inverter $i) {
        foreach ($this->tables as $table) {
            $cache = \yii::$app->cache;
            $cacheKey = __CLASS__ . '_' . $table;
            if ($cache->get($cacheKey)) {
                continue;
            }

            $isAttached = $this->db->getTableSchema($table)->getColumn('alias');
            if (!$isAttached) {
                $helper = new MigrationHelper([
                    'table' => $this->table($table)
                ]);
                $helper->attach();
            }

            $cache->set($cacheKey, 1);
        }
    }
}