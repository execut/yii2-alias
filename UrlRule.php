<?php
/**
 */

namespace execut\alias;


use yii\web\UrlRuleInterface;

class UrlRule implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        $models = $this->getModels();
        if (isset($models[$route]) && !empty($params['id'])) {
            return $this->findById($models[$route], $params['id']);
        }

        return false;
    }

    public function parseRequest($manager, $request)
    {
        $models = $this->getModels();
        foreach ($models as $route => $model) {
            if ($id = $this->findByAlias($model, $request->url)) {
                return [
                    $route,
                    [
                        'id' => $id,
                    ],
                ];
            }
        }

        return false;
    }

    protected function findById($modelClass, $id) {
        return $modelClass::find()->andWhere([
            'id' => $id,
        ])->select('alias')->createCommand()->queryScalar();
    }

    protected function findByAlias($modelClass, $url) {
        $url = trim($url, '/');
        return $modelClass::find()->andWhere([
            'alias' => $url,
        ])->select('id')->createCommand()->queryScalar();
    }

    /**
     * @return mixed
     */
    protected function getModels()
    {
        $models = \yii::$app->getModule('alias')->getModels();
        return $models;
    }
}