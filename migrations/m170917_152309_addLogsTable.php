<?php
namespace execut\alias\migrations;
use execut\yii\migration\Migration;
use execut\yii\migration\Inverter;

class m170917_152309_addLogsTable extends Migration
{
    public function initInverter(Inverter $i)
    {
        $i->table('alias_logs')->create($this->defaultColumns([
            'owner_id' => $this->integer()->unsigned()->notNull(),
            'owner_table' => $this->string()->notNull(),
            'old_alias' => $this->string()->notNull(),
            'visible' => $this->boolean()->notNull()->defaultValue('true'),
        ]));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
