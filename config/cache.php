<?php

$config = [
    'class' => 'yii\caching\FileCache',
    'as lazy' => [
        'class' => '\DevGroup\TagDependencyHelper\LazyCache',
    ],
];

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'cache-local.php';
if (file_exists($localConfig)) {
    $config = \yii\helpers\ArrayHelper::merge($config, require($localConfig));
}

return $config;
