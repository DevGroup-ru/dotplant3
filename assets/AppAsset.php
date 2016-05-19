<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application AssetBundle
 */
class AppAsset extends AssetBundle
{
    
    public $css = [
    ];

    public $js = [
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
