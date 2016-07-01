<?php

use yii\helpers\ArrayHelper;

$config = [
    'id' => 'dotplant3',
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => require('core.assetbundles.php'),
            'linkAssets' => true,
        ],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'eWUxxYyqkupp2kP1Dd2vhsez4nG63k9-',
        ],
        'user' => [
            'identityClass' => 'DevGroup\Users\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['@logout'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'class' => \DotPlant\Monster\MonsterWebView::className(),
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'DevGroup\Users\social\Google',
                    'clientId' => '443652971224-u945msnur3ok0e2rpd5b54msvhsdhook.apps.googleusercontent.com',
                    'clientSecret' => 'KQHavMtOBhBfy9Qnc52F7Fev',
                ],
                'vk' => [
                    'class' => 'DevGroup\Users\social\VKontakte',
                    'clientId' => '5223976',
                    'clientSecret' => 'qOgHTPZIGQK9NYmMMwTQ',
                ],
                'facebook' => [
                    'class' => 'DevGroup\Users\social\Facebook',
                    'clientId' => '1545062422479434',
                    'clientSecret' => 'c71aafc0e6614d6ac8011100249dd58d',
                ],
                'twitter' => [
                    'class' => 'DevGroup\Users\social\Twitter',
                    'consumerKey' => 'kZ5sQhDkr31tQm0sbif7RJdIh',
                    'consumerSecret' => 'ZdWn7wcPHcNaLh1QuRrN44MZdW1sjhGzmTVUIigdJRxQRugAMW',
                ],
            ],
        ],
    ],
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => require(__DIR__ . DIRECTORY_SEPARATOR . 'dev-ips.php'),
        'panels' => [
            'monster' => [
                'class' => 'DotPlant\Monster\Debug\MonsterPanel',
            ]
        ]
    ];
}

// merge common config
$config = ArrayHelper::merge($config, require(__DIR__ . DIRECTORY_SEPARATOR . 'common.php'));

// merge other configs
$configsToMerge = [
    'generated/web-generated.php',
    'web-local.php',
];

foreach ($configsToMerge as $file) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . $file;

    if (file_exists($file)) {
        $config = ArrayHelper::merge($config, require($file));
    }
}

return $config;
