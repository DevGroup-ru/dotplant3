<?php

use yii\rbac\PhpManager;

return [
    'id' => 'dp3-tests',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'cache' => '\yii\caching\DummyCache',
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=dotplant3-test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 86400,
        ],
        'authManager' => [
            'class' => PhpManager::class,
        ],
        'multilingual' => [
            'class' => DevGroup\Multilingual\Multilingual::class,
            'handlers' => [
                [
                    'class' => DevGroup\Multilingual\DefaultGeoProvider::class,
                    'default' => [
                        'country' => [
                            'name' => 'English',
                            'iso' => 'en',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
