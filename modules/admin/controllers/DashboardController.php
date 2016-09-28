<?php

namespace app\modules\admin\controllers;

use DevGroup\Frontend\helpers\RequestHelper;
use DotPlant\Monster\Repository;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Yii;
use yii\base\Module;
use yii\caching\Cache;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
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
                        'actions' => ['index', 'clear-cache', 'clear-monster', 'clear-assets'],
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
        return $this->flushCache();
    }

    public function actionClearAssets()
    {
        RequestHelper::allowAjaxOnly();
        RequestHelper::allowOnlyJsonRequest();
        $message = '';
        $except = [\Yii::getAlias('@webroot/assets/.gitignore'), \Yii::getAlias('@webroot/assets/index.html')];
        $dir = \Yii::getAlias('@webroot/assets');
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        /* @var RecursiveDirectoryIterator[] $files */
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        $hasErrors = false;
        if (stristr(PHP_OS, 'WIN') === false) {
            foreach ($files as $file) {
                if (!in_array($file->getRealPath(), $except)) {
                    if ($file->isDir() && $file->isLink() === false) {
                        $result = @rmdir($file->getRealPath());
                    } elseif ($file->isLink() === true) {
                        $result = @unlink($file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename());
                    } else {
                        $result = @unlink($file->getRealPath());
                    }
                    if (!$result) {
                        $hasErrors = true;
                    }
                }
            }
        }
        $message .= $hasErrors
            ? '<p>' . \Yii::t('app', 'Some assets are not flushed') . '</p>'
            : '<p>' . \Yii::t('app', 'Assets are flushed') . '</p>';
        return $message;
    }

    private function flushCache(Module $current = null)
    {
        $message = '';
        if ($current === null) {
            $current = \Yii::$app;
        }
        $modules = $current->getModules();
        foreach ($modules as $moduleName => $module) {
            if (is_array($module)) {
                $module = $current->getModule($moduleName, true);
            }
            if ($module instanceof Module) {
                $message .= $this->flushCache($module);
            }
        }
        $components = $current->getComponents();
        foreach ($components as $componentName => $component) {
            if (is_array($component)) {
                $component = $current->get($componentName);
            }
            if ($component instanceof Cache) {
                $message .= $component->flush()
                    ?
                    '<p>' . \Yii::t(
                        'app',
                        '{currentModuleName} {componentName} is flushed',
                        [
                            'currentModuleName' => $current->className(),
                            'componentName' => $component->className(),
                        ]
                    ) . '</p>'
                    : '';
            }
        }
        return $message;
    }
}
