<?php
use app\models\BackendMenu;
use yii\helpers\ArrayHelper;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?=
        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' =>
                    ArrayHelper::merge(
                        BackendMenu::getBackendMenu(),
                        [
                            ['label' => 'Login', 'url' => ['/users/auth/login'], 'visible' => Yii::$app->user->isGuest],
                            [
                                'label' => 'Logout',
                                'url' => ['/users/auth/logout'],
                                'visible' => !Yii::$app->user->isGuest
                            ],
                        ]
                    )

            ]
        ) ?>

    </section>

</aside>