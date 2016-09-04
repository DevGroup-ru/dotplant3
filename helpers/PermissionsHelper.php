<?php

namespace app\helpers;

use yii\base\Component;
use Yii;
use yii\rbac\Item;

/**
 * Class PermissionsHelper
 * Helper class for automatic creation hierarchic Roles and Permissions structure for DotPlant type extensions
 *
 * method accepts rules config like following:
 *
 * $config = [
 *  'ThirdRole' => [
 *      'descr' => 'Role with lowest permissions',
 *      'permits' => [
 *          'test-module-view' => 'View entries',
 *      ]
 *  ],
 *  'SecondRole' => [
 *      'descr' => 'Role with middle permissions',
 *      'permits' => [
 *          'test-module-create' => 'Create Entries'
 *      ],
 *  'roles' => [
 *          'ThirdRole'
 *      ],
 *  ],
 *  'FirstRole' => [
 *      'descr' => 'Role With the highest permissions',
 *      'permits' => [
 *          'test-module-delete' => 'Delete Entries'
 *      ],
 *      'roles' => [
 *          'SecondRole'
 *      ]
 *  ]
 * ];
 *
 * where:
 *  - array keys `FirstRole`, `SecondRole`, `ThirdRole` are creating role names
 *  - `descr` string role description
 *  - `permits` array of permissions accepted only by current role! Array structure must be like:
 *  [
 *    'permission-name' => 'permission description',
 *    'permission2-name' => 'permission 2 description',
 *    'permission3-name' => 'permission 3 description',
 *  ]
 * - `roles` array role names to be inherited by current role
 *
 * Roles in config must be listed in inverse order - from lowest to highest
 *
 * Roles and permissions naming agreement
 * Lets imagine we have module working with pages - PagesModule
 * Roles cold be like `PagesAdministrator`, `PagesModerator`, `PagesContentManager` etc.
 * Permissions could be like `pages-view`, `pages-edit`, `pages-publish`, `pages-delete` etc
 *
 * > Watch out! Your Roles and Permissions names must be unique in the global system scope, otherwise, you can have
 * unexpected access behavior!
 *
 * @package app\helpers
 */
class PermissionsHelper extends Component
{
    /**
     * Creates roles and permissions
     *
     * @param array $data
     */
    public static function createPermissions(array $data)
    {
        $createdMap = [];
        $auth = Yii::$app->authManager;
        foreach ($data as $roleName => $roleData) {
            if (null !== $auth->getRole($roleName)) {
                continue;
            }
            $role = $auth->createRole($roleName);
            $role->description = $roleData['descr'];
            if (true === $auth->add($role)) {
                $createdMap[$roleName] = $role;
                if (true === isset($roleData['permits'])) {
                    foreach ($roleData['permits'] as $permName => $permDescr) {
                        $canAdd = true;
                        if (true === isset($createdMap[$permName])) {
                            $permission = $createdMap[$permName];
                        } else {
                            if (null === $permission = $auth->getPermission($permName)) {
                                $permission = $auth->createPermission($permName);
                                $permission->description = $permDescr;
                                $canAdd = $auth->add($permission);
                            }
                        }
                        if ($permission instanceof Item && true === $canAdd) {
                            $auth->addChild($role, $permission);
                        }
                    }
                }
                if (true === isset($roleData['roles'])) {
                    foreach ($roleData['roles'] as $roleToInherit) {
                        if (
                            true === isset($createdMap[$roleToInherit])
                            && (true === $createdMap[$roleToInherit] instanceof Item)
                        ) {
                            $auth->addChild($role, $createdMap[$roleToInherit]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Removes roles and permissions
     *
     * @param array $data
     */
    public static function removePermissions(array $data)
    {
        $auth = Yii::$app->authManager;
        $permissions = [];
        foreach (array_column($data, 'permits') as $set) {
            $permissions = array_merge($permissions, array_keys($set));
        }
        foreach ($permissions as $name) {
            $item = $auth->getPermission($name);
            if (null !== $item) {
                $auth->remove($item);
            }
        }
        $roles = array_keys($data);
        foreach ($roles as $name) {
            $item = $auth->getRole($name);
            if (null !== $item) {
                $auth->remove($item);
            }
        }
    }
}