<aside class="main-sidebar">

    <section class="sidebar">

        <?=
        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'CMS', 'options' => ['class' => 'header']],
                    ['label' => 'Monster', 'icon' => 'fa fa-file-text', 'url' => ['/monster/visual-builder']],
                    ['label' => 'Extensions', 'icon' => 'fa fa-file', 'url' => ['/extensions-manager/extensions/index']],
                    ['label' => 'Events', 'icon' => 'fa fa-file', 'url' => ['/events/manage/index']],
                    ['label' => 'Users', 'icon' => 'fa fa-file', 'url' => ['/users/manage']],
                    ['label' => 'RBAC', 'icon' => 'fa fa-file', 'url' => ['/users/rbac']],
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['/users/auth/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'Logout', 'url' => ['/users/auth/logout'], 'visible' => !Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>