<?php

namespace app\controllers;

use DevGroup\DeferredTasks\actions\ReportQueueItem;
use DevGroup\DeferredTasks\helpers\DeferredHelper;
use DevGroup\DeferredTasks\helpers\ReportingTask;
use DevGroup\Users\actions\Registration;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\ContactForm;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class SiteController extends Controller
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

    public function actionIndex()
    {
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