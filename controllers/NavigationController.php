<?php
namespace app\controllers;

use app\models\Navigation;
use DevGroup\AdminUtils\controllers\BaseController;
use DevGroup\AdminUtils\traits\BackendRedirect;
use devgroup\JsTreeWidget\actions\AdjacencyList\TreeNodeMoveAction;
use devgroup\JsTreeWidget\actions\AdjacencyList\TreeNodesReorderAction;
use DotPlant\EntityStructure\actions\BaseEntityTreeAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class NavigationController
 * @package app\controllers
 */
class NavigationController extends BaseController
{
    use BackendRedirect;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'getTree'],
                        'allow' => true,
                        'roles' => ['core-navigation-view'],
                    ],
                    [
                        'actions' => ['edit', 'menuReorder', 'menuChangeParent', 'restore'],
                        'allow' => true,
                        'roles' => ['core-navigation-edit'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['core-navigation-delete'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['*'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ]

        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'getTree' => [
                'class' => BaseEntityTreeAction::class,
                'className' => Navigation::class,
                'modelLabelAttribute' => 'label'
            ],
            'menuReorder' => [
                'class' => TreeNodesReorderAction::class,
                'className' => Navigation::class,
            ],
            'menuChangeParent' => [
                'class' => TreeNodeMoveAction::class,
                'className' => Navigation::class,
            ],
        ];
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionIndex($id = 0)
    {
        $searchModel = new Navigation();
        $params = Yii::$app->request->get();
        $dataProvider = $searchModel->search($id, $params);

        /** @var Navigation $model */
        $model = Navigation::loadModel($id);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'model' => $model,
            ]
        );
    }


    /**
     * @param $parent_id
     * @param null $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws \Exception
     * @throws bool
     */
    public function actionEdit($parent_id, $id = null)
    {
        /** @var Navigation $model */
        $model = Navigation::loadModel(
            $id,
            true,
            false,
            86400,
            new NotFoundHttpException(
                Yii::t('app', "{model} with id :'{id}' not found!", [
                    'model' => Yii::t('app', 'Navigation'),
                    'id' => $id
                ])
            )
        );

        if ($model->isNewRecord === true) {
            $model->parent_id = $parent_id;
        } else {
            // populate translations relation as we need to save all
            $model->translations;
        }

        $model->loadDefaultValues();

        $isLoaded = $model->load(\Yii::$app->request->post());
        $hasAccess = ($model->isNewRecord && Yii::$app->user->can('core-navigation-create'))
            || (!$model->isNewRecord && Yii::$app->user->can('core-navigation-edit'));
        if ($isLoaded && $hasAccess === false) {
            throw new ForbiddenHttpException;
        }
        if ($isLoaded) {
            foreach (Yii::$app->request->post('NavigationTranslation', []) as $language => $data) {
                foreach ($data as $attribute => $translation) {
                    $model->translate($language)->$attribute = $translation;
                    if (!$model->translate($language)->validate()) {
                        $model->addErrors($model->translate($language)->getErrors());
                    }
                }
            }

            if (empty($model->params) === false) {
                $params = [];
                foreach ($model->params as $param) {
                    if (empty($param['key']) === false && empty($param['value']) === false) {
                        $params[$param['key']] = $param['value'];
                    }
                }
                $model->params = $params;
            }

            if ($model->save()) {
                $this->redirectUser(
                    $model->id,
                    true,
                    ['/navigation/index', 'id' => $model->parent_id],
                    ['/navigation/edit', 'id' => $model->id, 'parent_id' => $model->parent_id]
                );
            }
        }
        return $this->render(
            'form',
            [
                'model' => $model,
                'hasAccess' => $hasAccess
            ]
        );
    }

    /**
     * @param null $id
     * @param int $parent_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id = null, $hard = false, $parent_id = 0)
    {
        /** @var Navigation $model */
        $model = Navigation::loadModel(
            $id,
            true,
            false,
            86400,
            new NotFoundHttpException(
                Yii::t('app', "{model} with id :'{id}' not found!", [
                    'model' => Yii::t('app', 'Navigation'),
                    'id' => $id
                ])
            )
        );
        if ($hard === false) {
            ($model->delete() === false && $model->isDeleted() === true) ?
                Yii::$app->session->setFlash('info', Yii::t('app', 'Item has been hidden.')) :
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Item has not been hidden.'));
        } elseif ((bool)$hard === true) {
            $model->hardDelete() !== false ?
                Yii::$app->session->setFlash('danger', Yii::t('app', 'Item has been deleted.')) :
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Item has not been deleted.'));
        }
        return Yii::$app->request->isAjax ? 1 : $this->redirect(['index', 'parent_id' => $model->parent_id]);
    }

    public function actionRestore($id, $returnUrl)
    {
        /** @var Navigation $model */
        $model = Navigation::loadModel(
            $id,
            true,
            false,
            86400,
            new NotFoundHttpException(
                Yii::t('app', "{model} with id :'{id}' not found!", [
                    'model' => Yii::t('app', 'Navigation'),
                    'id' => $id
                ])
            )
        );

        (boolval($model->restore()) === true) ?
            Yii::$app->session->setFlash('info', Yii::t('app', 'Item has been restored.')) :
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Item has not been restored.'));


        return $this->redirect($returnUrl);
    }
}
