<?php

use app\helpers\PermissionsHelper;
use app\models\BackendMenu;
use app\models\Navigation;
use app\models\NavigationTranslation;
use yii\db\Migration;

class m160902_100019_navigation extends Migration
{

    public static $permissionsConfig = [
        'NavigationAdministrator' => [
            'descr' => 'Backend Menu Administration Role',
            'permits' => [
                'core-navigation-view' => 'View navigation grid',
                'core-navigation-edit' => 'Edit navigation',
                'core-navigation-create' => 'Create navigation',
                'core-navigation-delete' => 'Delete navigation',
            ],
        ],
    ];

    public function up()
    {

        mb_internal_encoding("UTF-8");
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;

        $this->createTable(
            Navigation::tableName(),
            [
                'id' => $this->primaryKey(),
                'parent_id' => $this->integer()->notNull()->defaultValue(0),
                'url' => $this->string(),
                'structure_id' => $this->integer(),
                'packed_json_params' => $this->text(),
                'css_class' => $this->string(),
                'rbac_check' => $this->string(),
                'context_id' => $this->integer()->notNull(),
                'sort_order' => $this->integer()->notNull()->defaultValue(0),
                'active' => $this->integer(1)->unsigned()->notNull()->defaultValue(1),
                'is_deleted' => $this->integer(1)->unsigned()->notNull()->defaultValue(0)
            ],
            $tableOptions
        );


        // translations
        $this->createTable(
            NavigationTranslation::tableName(),
            [
                'model_id' => $this->integer()->notNull(),
                'language_id' => $this->integer()->notNull(),
                'label' => $this->string()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey(
            'pk-navigation_translation-model_id-language_id',
            NavigationTranslation::tableName(),
            ['model_id', 'language_id']
        );

        $this->createIndex(
            'ix-navigation-parent_id-active-is_deleted',
            Navigation::tableName(),
            [
                'parent_id',
                'active',
                'is_deleted'
            ],
            false
        );

        $this->addForeignKey(
            'fk-navigation_translation-model_id',
            NavigationTranslation::tableName(),
            ['model_id'],
            Navigation::tableName(),
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        PermissionsHelper::createPermissions(self::$permissionsConfig);
        $auth = Yii::$app->authManager;
        if (null !== $adminRole = $auth->getRole('CoreAdministrator')) {
            $auth->addChild($adminRole, $auth->getRole('NavigationAdministrator'));
        }

        $this->insert(
            BackendMenu::tableName(),
            [
                'parent_id' => 0,
                'name' => 'Navigation',
                'icon' => 'fa fa-list',
                'sort_order' => 0,
                'rbac_check' => 'core-navigation-view',
                'css_class' => '',
                'route' => '/navigation/index',
                'translation_category' => 'app',
                'added_by_ext' => 'core'
            ]
        );
    }

    public function down()
    {
        $this->db->createCommand("SET foreign_key_checks = 0")->execute();
        $this->dropTable(NavigationTranslation::tableName());
        $this->dropTable(Navigation::tableName());
        $this->db->createCommand("SET foreign_key_checks = 1")->execute();
        PermissionsHelper::removePermissions(self::$permissionsConfig);
        $this->delete(
            BackendMenu::tableName(),
            [
                'rbac_check' => 'core-navigation-view'
            ]
        );
    }
}
