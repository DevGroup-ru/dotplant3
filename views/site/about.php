<?php

/* @var $this \DevGroup\Frontend\monster\MonsterWebView */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>

<?php $this->beginMonster() ?>

<?=
\app\widgets\ContentBlock005::widget([
    'title' => 'Advantages',
])
?>

<?php $this->endMonster() ?>
