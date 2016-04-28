<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application AssetBundle
 */
class AppAsset extends AssetBundle
{

    public $sourcePath = '@app/assets/frontend-monster/dist/assets/toolkit/';
    public $css = [
        'styles/toolkit.css',
    ];

    public $js = [
        'libs/libs.js',
        'scripts/toolkit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

    public function init()
    {
        parent::init();
//        $this->css[] = YII_ENV === 'dev' ? 'styles/toolkit.css' : 'styles/toolkit.min.css';

//        $this->js[] = YII_ENV === 'dev' ? 'scripts/toolkit.js' : 'scripts/toolkit.min.js';
    }
}
