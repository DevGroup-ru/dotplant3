<?php

$config = [
    'bootstrap' => [
        'log',
        'properties',
        'adminUtils',
        'extensions-manager',
        'users',
    ],
    'components' => [
        'cache' => require(__DIR__ . DIRECTORY_SEPARATOR . 'cache.php'),

        'db' => require(__DIR__ . DIRECTORY_SEPARATOR . 'db.php'),
        'filedb' => [
            'class' => 'yii2tech\filedb\Connection',
            'path' => __DIR__ . DIRECTORY_SEPARATOR . 'languages',
        ],

        'log' => require(__DIR__ . DIRECTORY_SEPARATOR . 'log.php'),
        'mailer' => require(__DIR__ . DIRECTORY_SEPARATOR . 'mailer.php'),

        'mutex' => [
            'class' => 'yii\mutex\MysqlMutex',
            'autoRelease' => false,
        ],

        'urlManager' => [
            'class' => \DevGroup\Multilingual\components\UrlManager::className(),
            'excludeRoutes' => [
                'newsletter/index',
                'newsletter/test',
                'site/deferred-report-queue-item',
                'debug/default',
            ],
            'rules' => [
                '' => 'site/index',
            ],
            'scriptUrl' => '',
            'baseUrl' => '',
            'forceScheme' => 'http',
            'forcePort' => 80,
            'hostInfo' => 'http://dotplant3.dev',
        ],
        'multilingual' => [
            'class' => \DevGroup\Multilingual\Multilingual::className(),
            'default_language_id' => 1,
            'handlers' => [
                [
                    'class' => \DevGroup\Multilingual\DefaultGeoProvider::className(),
                    'default' => [
                        'country' => [
                            'name' => 'Russia',
                            'iso' => 'ru',
                        ],
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

    ],
    'modules' => [
        'properties' => [
            'class' => 'DevGroup\DataStructure\Properties\Module',
        ],
        'adminUtils' => [
            'class' => 'DevGroup\AdminUtils\AdminModule',
        ],
        'extensions-manager' => [
            'class' => 'DevGroup\ExtensionsManager\ExtensionsManager',
        ],
        'users' => [
            'class' => 'DevGroup\Users\UsersModule',
            'layout' => '@app/views/layouts/in-container'
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
];
$generatedConfig = __DIR__ . '/generated/common-generated.php';
if (file_exists($generatedConfig)) {
    $config = \yii\helpers\ArrayHelper::merge($config, require($generatedConfig));
}
$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'common-local.php';
if (file_exists($localConfig)) {
    $config = \yii\helpers\ArrayHelper::merge($config, require($localConfig));
}

$config = \yii\helpers\ArrayHelper::merge($config, require(__DIR__ . DIRECTORY_SEPARATOR . 'gii.php'));

return $config;
