<?php
/**
 */

namespace execut\alias\crudFields;

class Plugin extends \execut\crudFields\Plugin
{
    public function getFields() {
        return [
            [
                'attribute' => 'alias',
            ],
        ];
    }
}