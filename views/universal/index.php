<?php
use yii\helpers\Html;


echo Html::a("Test page 1", ['show', 'entities' => [
    'app\models\Page' => [1],
]]);