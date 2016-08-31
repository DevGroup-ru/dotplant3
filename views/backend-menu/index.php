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

$this->title = Yii::t('app', 'Backend menu items');
$parent_id = is_object($model) ? $model->id : '0';

$this->params['breadcrumbs'][] = $this->title;
$buttons = Yii::$app->user->can('core-backend-menu-create') ?
    Html::a(
        Icon::show('plus') . '&nbsp'
        . Yii::t('app', 'New item'),
        ['/backend-menu/edit', 'parent_id' => $parent_id, 'returnUrl' => \DevGroup\AdminUtils\Helper::returnUrl()],
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
                    'treeDataRoute' => ['/backend-menu/getTree', 'selected_id' => $parent_id],
                    'reorderAction' => ['/backend-menu/menuReorder'],
                    'changeParentAction' => ['/backend-menu/menuChangeParent'],
                    'treeType' => TreeWidget::TREE_TYPE_ADJACENCY,
                    'contextMenuItems' => [
                        'open' => [
                            'label' => 'Open',
                            'action' => ContextMenuHelper::actionUrl(
                                ['/backend-menu/index'],
                                ['id']
                            ),
                        ],
                        'edit' => [
                            'label' => 'Edit',
                            'action' => ContextMenuHelper::actionUrl(
                                ['/backend-menu/edit', 'returnUrl' => Helper::returnUrl()]
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
                        'name',
                        'icon',
                        'css_class',
                        'rbac_check',
                        'translation_category',
                        [
                            'class' => ActionColumn::class,
                            'buttons' => function ($model, $key, $index, $column) {
                                return [
                                    'edit' => [
                                        'url' => '/backend-menu/edit',
                                        'icon' => 'pencil',
                                        'class' => 'btn-primary',
                                        'attrs' => ['parent_id'],
                                        'label' => Yii::t('app', 'Edit'),
                                    ],
                                    'delete' => [
                                        'url' => '/backend-menu/delete',
                                        'icon' => 'trash-o',
                                        'class' => 'btn-warning',
                                        'label' => Yii::t('app', 'Delete'),
                                        'options' => [
                                            'data-action' => 'delete',
                                        ],
                                    ]
                                ];
                            },
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</section>




