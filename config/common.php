<?php

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@login' => '/users/auth/login',
        '@logout' => '/users/auth/logout',
    ],
    'bootstrap' => [
        'log',
        'properties',
        'users',
        'DotPlant\Monster\ExtensionBootstrap',
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
            'class' => yii\mutex\MysqlMutex::class,
            'autoRelease' => false,
        ],
        'urlManager' => [
            'class' => DevGroup\Multilingual\components\UrlManager::className(),
            'excludeRoutes' => [
                'newsletter/index',
                'newsletter/test',
                'site/deferred-report-queue-item',
                'debug/default',
            ],
            'rules' => [
//                '' => 'site/index',
                [
                    'class' => 'DotPlant\EntityStructure\components\StructureUrlRule',
                ],
            ],
            'scriptUrl' => '',
            'baseUrl' => '',
            'forceScheme' => 'http',
            'forcePort' => 80,
            'hostInfo' => 'http://dotplant3.dev',
        ],
        'monsterRepository' => [
            'class' => DotPlant\Monster\Repository::class,
        ],
        'monsterCache' => [
            'class' => DotPlant\Monster\Cache::class,
        ],
        'monsterBh' => [
            'class' => DotPlant\Monster\MonsterBh::class,
            'expander' => 'monsterBhExpander',
        ],
        'monsterBhExpander' => [
            'class' => DotPlant\Monster\MonsterBhExpander::class,
        ],
        'multilingual' => [
            'class' => DevGroup\Multilingual\Multilingual::class,
            'handlers' => [
                [
                    'class' => DevGroup\Multilingual\DefaultGeoProvider::class,
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
            'class' => yii\rbac\DbManager::class,
            'cache' => 'cache',
        ],
    ],
    'modules' => [
        'properties' => [
            'class' => DevGroup\DataStructure\Properties\Module::class,
        ],
        'adminUtils' => [
            'class' => DevGroup\AdminUtils\AdminModule::class,
        ],
        'extensions-manager' => [
            'class' => DevGroup\ExtensionsManager\ExtensionsManager::class,
        ],
        'users' => [
            'class' => DevGroup\Users\UsersModule::class,
        ],
        'monster' => [
            'class' => DotPlant\Monster\MonsterModule::class,
        ],
        'multilingual' => [
            'class' => DevGroup\Multilingual\Module::class,
        ],
        'events' => [
            'class' => DevGroup\EventsSystem\Module::class,
            'layout' => '@app/views/layouts/admin',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '@app/views/layouts/admin',
        ],
        'measure' => [
            'class' => DevGroup\Measure\Module::class,
            'layout' => '@app/views/layouts/admin',
        ]
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
$aliasesConfig = __DIR__ . DIRECTORY_SEPARATOR . 'generated/aliases-generated.php';
if (true === file_exists($aliasesConfig)) {
    $generated = require $aliasesConfig;
    isset($config['aliases']) ?
        $config['aliases'] = \yii\helpers\ArrayHelper::merge($config['aliases'], $generated)
        : $config['aliases'] = $generated;
}
$config = \yii\helpers\ArrayHelper::merge($config, require(__DIR__ . DIRECTORY_SEPARATOR . 'gii.php'));

return $config;
