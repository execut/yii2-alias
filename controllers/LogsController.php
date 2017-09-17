<?php
/**
 */

namespace execut\alias\controllers;


use execut\alias\models\Log;
use execut\crud\params\Crud;
use yii\filters\AccessControl;
use yii\web\Controller;

class LogsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        $crud = new Crud([
            'modelClass' => Log::class,
            'module' => 'alias',
            'moduleName' => 'Logs',
            'modelName' => Log::MODEL_NAME,
        ]);
        return $crud->actions();
    }
}