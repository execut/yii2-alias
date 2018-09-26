<?php
/**
 */

namespace execut\alias\bootstrap;


use execut\alias\Module;
use execut\alias\UrlRule;
use execut\yii\Bootstrap;

class Console extends Common
{
    public function bootstrap($app)
    {
        parent::bootstrap($app);
        $this->initUrlRules($app);
    }
}