<?php

use yii\helpers\ArrayHelper;

$config = [
    'class' => 'yii\swiftmailer\Mailer',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => true,
];

$configsToMerge = [
    '../modules/site/config/mailer.php',
    'mailer-local.php',
];

foreach ($configsToMerge as $file) {
    $file = __DIR__ . DIRECTORY_SEPARATOR . $file;
    if (file_exists($file)) {
        $config = ArrayHelper::merge($config, require($file));
    }
}

return $config;
