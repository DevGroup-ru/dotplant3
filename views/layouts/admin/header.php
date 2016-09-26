<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">dp3</span><span class="logo-lg">dotplant3</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li>
                    <a href="#clear-cache" onclick="jQuery.post('/admin/dashboard/clear-cache', {}, function (data) {alert(data);}, 'json'); return false;" title="Clear cache">
                        <i class="fa fa-eraser"></i>
                        <span class="label label-success"><i class="fa fa-hashtag"></i></span>
                    </a>
                </li>
                <li>
                    <a href="#clear-monster" onclick="jQuery.post('/admin/dashboard/clear-monster', {}, function (data) {alert(data);}, 'json'); return false;" title="Clear monster">
                        <i class="fa fa-eraser"></i>
                        <span class="label label-success"><i class="fa fa-paw"></i></span>
                    </a>
                </li>
                <li>
                    <a href="#clear-assets" onclick="jQuery.post('/admin/dashboard/clear-assets', {}, function (data) {alert(data);}, 'json'); return false;" title="Clear assets">
                        <i class="fa fa-eraser"></i>
                        <span class="label label-success"><i class="fa fa-folder"></i></span>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= '' #Html::encode(Yii::$app->user->identity->username) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= '' #Html::encode(Yii::$app->user->identity->username) ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
<!--                        <li class="user-body">-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Followers</a>-->
<!--                            </div>-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Sales</a>-->
<!--                            </div>-->
<!--                            <div class="col-xs-4 text-center">-->
<!--                                <a href="#">Friends</a>-->
<!--                            </div>-->
<!--                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
<!--                            <div class="pull-left">-->
<!--                                <a href="#" class="btn btn-default btn-flat">Profile</a>-->
<!--                            </div>-->
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>