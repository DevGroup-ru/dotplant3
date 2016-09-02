<?php
namespace app\controllers;

use app\models\Navigation;
use DevGroup\AdminUtils\controllers\BaseController;
use DevGroup\AdminUtils\traits\BackendRedirect;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use devgroup\JsTreeWidget\actions\AdjacencyList\FullTreeDataAction;
use devgroup\JsTreeWidget\actions\AdjacencyList\TreeNodeMoveAction;
use devgroup\JsTreeWidget\actions\AdjacencyList\TreeNodesReorderAction;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['edit', 'menuReorder', 'menuChangeParent'],
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
                'class' => FullTreeDataAction::class,
                'className' => Navigation::class,
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
        $searchModel->parent_id = $id;
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
     * @param null $parent_id
     * @param null $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
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
                    'model' => Yii::t('app', 'BackendMenu'),
                    'id' => $id
                ])
            )
        );

        if ($model->isNewRecord === true) {
            $model->parent_id = $parent_id;
        }

        $isLoaded = $model->load(\Yii::$app->request->post());
        $hasAccess = ($model->isNewRecord && Yii::$app->user->can('core-backend-menu-create'))
            || (!$model->isNewRecord && Yii::$app->user->can('core-backend-menu-edit'));
        if ($isLoaded && $hasAccess === false) {
            throw new ForbiddenHttpException;
        }
        if ($isLoaded) {
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
    public function actionDelete($id = null, $parent_id = 0)
    {
        /** @var Navigation $model */
        $model = Navigation::loadModel(
            $id,
            true,
            false,
            86400,
            new NotFoundHttpException(
                Yii::t('app', "{model} with id :'{id}' not found!", [
                    'model' => Yii::t('app', 'BackendMenu'),
                    'id' => $id
                ])
            )
        );
        $model->delete() !== false ?
            Yii::$app->session->setFlash('success', Yii::t('app', 'Object has been removed')) :
            Yii::$app->session->setFlash('error', Yii::t('app', 'Object has not been removed'));

        return $this->redirect(['index', 'parent_id' => $model->parent_id]);
    }
}
