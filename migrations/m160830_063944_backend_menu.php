<?php

use app\helpers\PermissionsHelper;
use app\models\BackendMenu;
use yii\db\Migration;

class m160830_063944_backend_menu extends Migration
{
    public static $permissionsConfig = [
        'BackendMenuAdministrator' => [
            'descr' => 'Backend Menu Administration Role',
            'permits' => [
                'core-backend-menu-view' => 'View backend menu grid',
                'core-backend-menu-edit' => 'Edit backend menu',
                'core-backend-menu-create' => 'Create backend menu',
                'core-backend-menu-delete' => 'Delete backend menu',
            ],
        ],
    ];

    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;
        $this->createTable(
            BackendMenu::tableName(),
            [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer()->unsigned()->defaultValue(0),
                'name' => $this->string()->notNull(),
                'icon' => $this->string(),
                'sort_order' => $this->integer()->unsigned()->defaultValue(0),
                'added_by_ext' => $this->string(),
                'rbac_check' => $this->string(),
                'css_class' => $this->string(),
                'url' => $this->string(),
                'route' => $this->string(),
                'packed_json_params' => $this->text(),
                'translation_category' => $this->string(120)->notNull()->defaultValue('app')
            ],
            $tableOptions
        );
        $this->createIndex('ix-backendmenu-parent_id', BackendMenu::tableName(), ['parent_id']);

        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext'
            ],
            [
                [
                    0,
                    'CMS',
                    'fa fa-cubes',
                    0,
                    'backend-view',
                    'header',
                    '',
                    'app',
                    'core'
                ],
            ]
        );

        $cmsID = $this->db->lastInsertID;

        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext'
            ],
            [
                [
                    0,
                    'Users',
                    'fa fa-users',
                    0,
                    '',
                    'header',
                    '',
                    'app',
                    'users'
                ],
            ]
        );

        $userId = $this->db->lastInsertID;

        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext'
            ],
            [
                [
                    0,
                    'Multilingual',
                    'fa fa-language',
                    0,
                    '',
                    'header',
                    '',
                    'app',
                    'core'
                ],
            ]
        );
        $multilingualId = $this->db->lastInsertID;

        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext'
            ],
            [
                [
                    0,
                    'Menu Yii2',
                    'fa fa-bars',
                    0,
                    '',
                    'header',
                    '',
                    'app',
                    'core'
                ],
            ]
        );

        $yii2Id = $this->db->lastInsertID;

        $this->batchInsert(
            BackendMenu::tableName(),
            [
                'parent_id',
                'name',
                'icon',
                'sort_order',
                'rbac_check',
                'css_class',
                'route',
                'translation_category',
                'added_by_ext'
            ],
            [
                [
                    $multilingualId,
                    'Context',
                    'fa fa-file-text-o',
                    0,
                    'multilingual-view-context',
                    '',
                    '/multilingual/context-manage/index',
                    'app',
                    'multilingual'
                ],
                [
                    $multilingualId,
                    'Conutry Language',
                    'fa fa-info',
                    0,
                    'multilingual-view-context',
                    '',
                    '/multilingual/country-language-manage/index',
                    'app',
                    'multilingual'
                ],
                [
                    0,
                    'Measures',
                    'fa fa-asterisk',
                    0,
                    'measure-view-measure',
                    '',
                    '/measure/measures-manage/index',
                    'app',
                    'measure'
                ],
                [
                    0,
                    'Monster',
                    'fa fa-paw',
                    0,
                    'backend-view',
                    '',
                    '/monster/visual-builder',
                    'app',
                    'monster'
                ],
                [
                    0,
                    'Extensions',
                    'fa fa-cogs',
                    0,
                    'extensions-manager-view-extensions',
                    '',
                    '/extensions-manager/extensions/index',
                    'app',
                    'extensions'
                ],
                [
                    0,
                    'Events',
                    'fa fa-spinner',
                    0,
                    'events-system-view-handler',
                    '',
                    '/events/handlers-manage/index',
                    'app',
                    'events'
                ],
                [
                    0,
                    'Backend menu',
                    'fa fa-bars',
                    0,
                    'core-backend-menu-view',
                    '',
                    '/backend-menu/index',
                    'app',
                    'core'
                ],

                [
                    $userId,
                    'Users',
                    'fa fa-user',
                    0,
                    'users-user-view',
                    '',
                    '/users/users-manage/index',
                    'app',
                    'users'
                ],
                [
                    $userId,
                    'RBAC',
                    'fa fa-user-secret',
                    0,
                    'users-role-view',
                    '',
                    '/users/rbac-manage/index',
                    'app',
                    'users'
                ],
                [
                    $yii2Id,
                    'Gii',
                    'fa fa-file-code-o',
                    0,
                    'backend-view',
                    '',
                    '/gii',
                    'app',
                    'core'
                ],
                [
                    $yii2Id,
                    'Debug',
                    'fa fa-dashboard',
                    0,
                    'backend-view',
                    '',
                    '/debug',
                    'app',
                    'core'
                ],
            ]
        );

        PermissionsHelper::createPermissions(self::$permissionsConfig);
        $auth = Yii::$app->authManager;
        if (null !== $adminRole = $auth->getRole('CoreAdministrator')) {
            $auth->addChild($adminRole, $auth->getRole('BackendMenuAdministrator'));
        }
    }

    public function down()
    {
        $this->dropTable(BackendMenu::tableName());
        PermissionsHelper::removePermissions(self::$permissionsConfig);
    }
}
