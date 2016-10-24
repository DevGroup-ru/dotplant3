<?php

namespace app\controllers;

use app\models\Navigation;
use DevGroup\DeferredTasks\actions\ReportQueueItem;
use DevGroup\DeferredTasks\helpers\DeferredHelper;
use DevGroup\DeferredTasks\helpers\ReportingTask;
use DevGroup\Frontend\controllers\FrontendController;
use DotPlant\Monster\Repository;
use yii;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class SiteController extends FrontendController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'deferred-report-queue-item' => [
                'class' => ReportQueueItem::className(),
            ],
        ];
    }

    public function actionIndex1()
    {

        $dd = Navigation::getNavigation(0);

        $dd = 1;


//        $annotator = new Annotator();
//        $tree = $annotator->annotate(
//            'toolkit.scss',
//            Yii::getAlias('@app/assets/frontend-monster/src/assets/toolkit/styles/')
//        );
//
////        $json = Json::encode($tree, JSON_PRETTY_PRINT);
////        echo "<h1>EncodedJSON</h1>" . strlen($json) . "<pre>$json</pre>";
////        $json = Json::decode($json);
////        VarDumper::dump($json, 50, true);
//
//        $encoded = serialize($tree);
//        file_put_contents(
//            Yii::getAlias('@app/runtime/monster-materials.ser'),
//            $encoded
//        );
//        file_put_contents(
//            Yii::getAlias('@app/runtime/monster-groups.ser'),
//            serialize(MonsterGroup::$globalIdentityMap)
//        );
//        file_put_contents(
//            Yii::getAlias('@app/runtime/monster-vars.ser'),
//            serialize(MonsterVariable::$globalIdentityMap)
//        );
//
//
//        $decoded = unserialize($encoded);
//        VarDumper::dump($decoded, 50, true);
//
//        echo "<h1>Original tree</h1>";
//        VarDumper::dump($tree, 50, true);
//        echo "<h1>All Vars</h1>";
//        VarDumper::dump(MonsterVariable::$globalIdentityMap, 10, true);
//        echo "<h1>All Groups</h1>";
//        VarDumper::dump(MonsterGroup::$globalIdentityMap, 10, true);
//        echo "<h1>All Files</h1>";
//        VarDumper::dump($annotator->processedFiles, 10, true);
//        die();
//        VarDumper::dump(Yii::$app->bemRepository->materials, 3, true);
//        VarDumper::dump(Yii::$app->bemRepository->groups, 10, true);

        return $this->render('index');
    }

    public function actionUpdateComposer()
    {
        $task = new ReportingTask();
        $task->cliCommand(
            'php',
            [
                './composer.phar',
                'update',
                '--no-ansi',
                '--no-progress',
                '-n',
                '--prefer-dist',
                '-v'
            ]
        );
        if ($task->registerTask()) {
            DeferredHelper::runImmediateTask($task->model()->id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'queueItemId' => $task->model()->id,
            ];
        } else {
            throw new ServerErrorHttpException("Unable to start task");
        }
    }


    public function actionAbout()
    {
        return $this->render('about');
    }

}