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

    public function rules() {
        return [
            ['alias', 'unique', 'skipOnEmpty' => false],
        ];
    }
}