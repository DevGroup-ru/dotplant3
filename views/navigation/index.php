<?php
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */
use DevGroup\AdminUtils\columns\ActionColumn;
use DevGroup\AdminUtils\Helper;
use devgroup\JsTreeWidget\helpers\ContextMenuHelper;
use devgroup\JsTreeWidget\widgets\TreeWidget;
use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\bootstrap\Html;
use kartik\icons\Icon;

$this->title = Yii::t('app', 'Navigation items');
$parent_id = is_object($model) ? $model->id : '0';

$this->params['breadcrumbs'][] = $this->title;

$buttons = Yii::$app->user->can('core-navigation-create') ?
    Html::a(
        Icon::show('plus') . '&nbsp'
        . Yii::t('app', 'New item'),
        ['/navigation/edit', 'parent_id' => $parent_id, 'returnUrl' => \DevGroup\AdminUtils\Helper::returnUrl()],
        ['class' => 'btn btn-success']
    ) : '';
$gridTpl = <<<TPL
<div class="box-body">
    {summary}
    {items}
</div>
<div class="box-footer">
    <div class="row list-bottom">
        <div class="col-sm-5">
            {pager}
        </div>
        <div class="col-sm-7">
            <div class="btn-group pull-right" style="margin: 20px 0;">
                $buttons
            </div>
        </div>
    </div>
</div>
TPL;
?>
<section id="list-backend-menu">
    <div class="row">
        <div class="col-xs-4">
            <div class="box">
                <?= TreeWidget::widget([
                    'treeDataRoute' => ['/navigation/getTree', 'selected_id' => $parent_id],
                    'reorderAction' => ['/navigation/menuReorder'],
                    'changeParentAction' => ['navigation/menuChangeParent'],
                    'treeType' => TreeWidget::TREE_TYPE_ADJACENCY,
                    'contextMenuItems' => [
                        'open' => [
                            'label' => 'Open',
                            'action' => ContextMenuHelper::actionUrl(
                                ['/navigation/index'],
                                ['id']
                            ),
                        ],
                        'edit' => [
                            'label' => 'Edit',
                            'action' => ContextMenuHelper::actionUrl(
                                ['/navigation/edit', 'returnUrl' => Helper::returnUrl()]
                            ),
                        ]
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="box">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => $gridTpl,
                    'summaryOptions' => ['class' => 'summary col-md-12 dataTables_info'],
                    'tableOptions' => [
                        'class' => 'table table-bordered table-hover table-responsive dataTable',
                    ],
                    'columns' => [
                        [
                            'class' => DataColumn::class,
                            'attribute' => 'id',
                        ],
                        'label',
                        'css_class',
                        'rbac_check',
                        [
                            'attribute' => 'is_deleted',
                            'label' => Yii::t('app', 'Show deleted?'),
                            'value' => function ($model) {
                                return $model->isDeleted() === true ? Yii::t('app', 'Deleted') : Yii::t('app', 'Active');
                            },
                            'filter' => [
                                Yii::t('app', 'Show only active'),
                                Yii::t('app', 'Show only deleted')
                            ],
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'id' => null,
                                'prompt' => Yii::t('app', 'Show all')
                            ]
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'buttons' => function ($model, $key, $index, $column) {
                                $result = [
                                    'edit' => [
                                        'url' => 'edit',
                                        'icon' => 'pencil',
                                        'class' => 'btn-primary',
                                        'label' => Yii::t('app', 'Edit'),
                                    ],
                                ];

                                if ($model->isDeleted() === false) {
                                    $result['delete'] = [
                                        'url' => 'delete',
                                        'visible' => false,
                                        'icon' => 'trash-o',
                                        'class' => 'btn-warning',
                                        'label' => Yii::t('app', 'Delete'),
                                        'options' => [
                                            'data-action' => 'delete',
                                        ],
                                    ];
                                } else {
                                    $result['restore'] = [
                                        'url' => 'restore',
                                        'icon' => 'undo',
                                        'class' => 'btn-info',
                                        'label' => Yii::t('app', 'Restore'),
                                    ];
                                    $result['delete'] = [
                                        'url' => 'delete',
                                        'urlAppend' => ['hard' => 1],
                                        'icon' => 'trash-o',
                                        'class' => 'btn-danger',
                                        'label' => Yii::t('app', 'Delete'),
                                        'options' => [
                                            'data-action' => 'delete',
                                        ],
                                    ];
                                }

                                return $result;
                            },
                            'appendUrlParams' => [
                                'parent_id' => $parent_id,
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</section>




