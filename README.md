# yii2-alias
**Warning! Documentation is incomplete. Writing in the progress.**

Yii2 module for work with url aliases and routing it between related records in database.

### Install

Either run

```
$ php composer.phar require execut/yii2-crud "dev-master"
```

or add

```
"execut/yii2-crud": "dev-master"
```

to the ```require``` section of your `composer.json` file.

## Usage

For configure url rule add alias bootstrap to your application bootstrap config section:
```php
...
'bootstrap' => [
    ...
    [
        'class' => execut\alias\bootstrap\Frontend::class,
    ],
    ...
]
...
```
For adding changes in target models tables structure, attach module in your console application config module:
```php
'modules' => [
    'alias' => [
        'class' => execut\alias\Module::class,
        'models' => [
            'yourUrlRouteHere' => Model::class,
        ],
    ],
],
```