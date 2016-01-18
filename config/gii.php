<?php

if (YII_ENV_DEV) {
    return [
        'bootstrap' => ['gii'],
        'modules' => [
            'gii' => [
                'class' => 'yii\gii\Module',
                'allowedIPs' => require(__DIR__ . DIRECTORY_SEPARATOR . 'dev-ips.php'),
            ],
        ],
    ];
} else {
    return [];
}