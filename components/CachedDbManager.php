<?php

namespace app\components;

use yii;

class CachedDbManager extends \yii\rbac\DbManager
{
    /**
     * @var \yii\caching\Cache Application cache component that will be used for caching
     */
    public $cache = 'cache';

    /**
     * @var integer Lifetime of cached data in seconds
     */
    public $lifetime = 3600;

    /**
     * @var string cache prefix to ovoid collisions
     */
    public $cachePrefix = 'CachedDbManager_';

    public function checkAccess($userId, $permissionName, $params = [])
    {

        if (count($params)>0) {
            return parent::checkAccess($userId, $permissionName, $params);
        }

        $cacheKey = $this->cachePrefix.'userAccessCheck:'.$userId.':'.$permissionName;

        /*
            Due to yii2 cache system, where we receive 'false' from cache component
            we have to store array in cache to ensure that 'false' doesn't mean
            that access is restricted
        */
        $check = $this->getCache()->get($cacheKey);

        if (!is_array($check)) {
            $check = [
                parent::checkAccess($userId, $permissionName, $params)
            ];

            $this->getCache()->set($cacheKey, $check, $this->lifetime);
        }

        return $check[0];
    }

    private function getCache()
    {
        return \Yii::$app->cache;
    }
}