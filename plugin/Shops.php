<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 9/18/18
 * Time: 2:55 PM
 */

namespace execut\alias\plugin;


use execut\alias\Plugin;
use execut\shops\models\Shop;

class Shops implements Plugin
{
    public function getModels()
    {
        return [
            [
                'modelClass' => Shop::class,
                'route' => 'shops/shops/view',
                'pattern' => 'adresa-magazinov/<id:.+>',
            ],
        ];
    }
}