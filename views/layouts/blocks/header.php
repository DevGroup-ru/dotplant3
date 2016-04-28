<?php

/**
 * @var $this \yii\web\View
 */

use app\assets\AppAsset;
use app\extensions\DefaultTheme\assets\DefaultThemeAsset;
use app\extensions\DefaultTheme\models\ThemeParts;
use app\modules\seo\helpers\HtmlTagHelper;
use yii\helpers\Html;


AppAsset::register($this);


?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="content-language" content="<?=Yii::$app->language?>">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>

</head>
<body itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody(); ?>
