<?php

namespace app\modules\admin\controllers;

use DevGroup\Frontend\helpers\RequestHelper;
use Yii;
use yii\caching\Cache;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'accessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['backend-view'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionClearCache()
    {
        RequestHelper::allowAjaxOnly();
        RequestHelper::allowOnlyJsonRequest();
        return Yii::$app->cache->flush();
    }

}
