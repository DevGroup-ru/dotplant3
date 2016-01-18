<?php

use yii\helpers\ArrayHelper;

$ips = [
    '127.0.0.1',
    '::1',
];


$localFile = __DIR__ . DIRECTORY_SEPARATOR . 'dev-ips-local.php';
if (file_exists($localFile)) {
    $ips = ArrayHelper::merge($ips, require($localFile));
}

return $ips;