<?php
use yii\web\View;

return [
    'yii\web\JqueryAsset' => [
        'sourcePath' => null,   // do not publish the bundle
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'yii\jui\JuiAsset' => [
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js',
        ],
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.min.css',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'yii\widgets\MaskedInputAsset' => [
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.1/jquery.inputmask.bundle.min.js',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'devgroup\jsoneditor\JsoneditorAsset' => [
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/5.5.6/jsoneditor.min.js',
        ],
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/5.5.6/jsoneditor.min.css',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'devgroup\JsTreeWidget\widgets\JsTreeAssetBundle' => [
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.2/jstree.min.js',
        ],
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.2/themes/default/style.min.css',
        ],
    ],
    'yii\bootstrap\BootstrapAsset' =>[
        'sourcePath' => null,
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'yii\bootstrap\BootstrapPluginAsset' =>[
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js',
        ],
        'jsOptions' => [
            'position' => View::POS_HEAD,
        ],
    ],
    'yii\bootstrap\BootstrapThemeAsset' =>[
        'sourcePath' => null,
        'css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap-theme.min.css',
        ],
    ],
    'yii\validators\PunycodeAsset' => [
        'sourcePath' => null,
        'js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/punycode/2.0.0/punycode.min.js',
        ],
    ],
];