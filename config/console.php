<?php

use yii\helpers\ArrayHelper;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$config = [
    'id' => 'dotplant3-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app\commands',
    'components' => [

    ],

    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
        'migrate' => [
            'class' => 'dmstr\console\controllers\MigrateController'
        ],
        'migrate-legacy' => [
            'class' => 'yii\console\controllers\MigrateController',
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

// merge common config
$config = ArrayHelper::merge($config, require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'));

$generatedConfig = __DIR__ . '/generated/console-generated.php';
if (file_exists($generatedConfig)) {
    $config = \yii\helpers\ArrayHelper::merge($config, require($generatedConfig));
}

return $config;
