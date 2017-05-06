<?php
/**
 */

namespace execut\alias\crudFields;

class Plugin
{
    public $owner = null;
    public function getFields() {
        return [
            [
                'attribute' => 'alias',
            ],
        ];
    }
}