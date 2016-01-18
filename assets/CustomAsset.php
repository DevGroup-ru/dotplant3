<?php

namespace app\assets;

use yii\web\AssetBundle;

class CustomAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/custom';
    public $js = [
        'main.js',
        'custom.js',
    ];
}