<?php
/**
 */

namespace execut\alias;


use execut\alias\models\Log;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\CompositeUrlRule;
use yii\web\Controller;
use yii\web\UrlRuleInterface;

class UrlRule extends CompositeUrlRule
{
    public function createUrl($manager, $route, $params)
    {
        $model = $this->getModelByRoute($route);
        if ($model) {
            if (array_key_exists('alias', $params)) {
                $params['id'] = $params['alias'];
                unset($params['alias']);
            } else if (!empty($params['id'])) {
                $id = $this->findById($model, $params['id']);
                if ($id !== false) {
                    if ($id === null) {
                        $id = '';
                    }

                    $params['id'] = $id;
                }
            }
        }

        $url = parent::createUrl($manager, $route, $params);

        return $url;
    }

    public function parseRequest($manager, $request)
    {
        foreach ($this->rules as $rule) {
            /* @var $rule UrlRule */
            if ($request->url === '/' && $rule->route === \yii::$app->defaultRoute) {
                $params = [$rule->route, ['id' => '']];
            } else {
                $params = $rule->parseRequest($manager, $request);
            }

            if ($params !== false) {
                if (!$params || empty($params[1]) || !isset($params[1]['id'])) {
                    continue;
                }

                $model = $this->getModelByRoute($params[0]);
                if (!$model) {
                    continue;
                }

                if ($id = $this->findByAlias($model, $params[1]['id'])) {
                    $params[1]['id'] = $id;

                    return $params;
                }
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
        $q = $modelClass::find()->select('id');
        if ($url === '') {
            $q->andWhere('alias is null or alias=\'-\'');
        } else {
            $q->andWhere([
                'alias' => $url,
            ]);
        }

        $result = $q->createCommand()->queryScalar();
        if (!$result) {
            $redirectedModel = Log::find()->byOldAlias($url, $modelClass)->select('owner_id')->one();
            if ($redirectedModel) {
                Event::on(Controller::class, 'beforeAction', function () use ($modelClass, $redirectedModel) {
                    \yii::$app->response->redirect([
                        $this->getRouteByModel($modelClass),
                        'id' => $redirectedModel->owner_id,
                    ], 301);
                    \yii::$app->end();
                });
            }
        }

        return $result;
    }

    protected function getRouteByModel($modelClass) {
        $models = $this->getModels();

        foreach ($models as $model => $rule) {
            if ($rule['modelClass'] === $modelClass) {
                return $rule['route'];
            }
        }
    }

    protected function getModelByRoute($route, $isReverse = false) {
        $models = $this->getModels();
        if ($isReverse) {
            $models = array_reverse($models);
        }

        foreach ($models as $model => $rule) {
            if ($rule['route'] === $route) {
                return $rule['modelClass'];
            }
        }
    }

    /**
     * @return mixed
     */
    protected function getModels()
    {
        $models = \yii::$app->getModule('alias')->getModels();
        foreach ($models as &$rule) {
            unset($rule['order']);
        }

        return $models;
    }

    public function createRules()
    {
        $models = $this->getModels();
        $rules = [];
        foreach ($models as $model => $rule) {
            unset($rule['modelClass']);
            unset($rule['order']);
            if (!isset($rule['encodeParams'])) {
                $rule['encodeParams'] = false;
            }

            $rule = ArrayHelper::merge([
                'class' => \yii\web\UrlRule::class,
                'pattern' => '<id:.*>',
            ], $rule);

            $rule = \yii::createObject($rule);

            $rules[] = $rule;
        }

        return $rules;
    }

//    protected function iterateRules($rules, $manager, $route, $params)
//    {
//        $rules = array_reverse($rules);
//        var_dump($rules);
//        exit;
//
//        return parent::iterateRules($rules, $manager, $route, $params);
//    }
}