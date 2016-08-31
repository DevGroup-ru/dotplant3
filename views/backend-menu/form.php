<?php
use app\models\BackendMenu;
use DevGroup\AdminUtils\FrontendHelper;
use unclead\widgets\MultipleInput;
use unclead\widgets\MultipleInputColumn;
use yii\widgets\ActiveForm;

/**
 * @var $model BackendMenu
 * @var $hasAccess bool
 * @var $this \yii\web\View
 */
$this->title = Yii::t('app', 'Edit backend menu item');

$this->params['breadcrumbs'][] = [
    'url' => ['/backend-menu/index'],
    'label' => Yii::t('app', 'Backend menu items')
];
if (($model->parent_id > 0)
    && (null !== $parent = BackendMenu::findOne($model->parent_id))
) {
    $this->params['breadcrumbs'][] = [
        'url' => [
            '/backend-menu/index',
            'id' => $parent->id,
            'parent_id' => $parent->parent_id
        ],
        'label' => $parent->name
    ];
}
$this->params['breadcrumbs'][] = $this->title;

$paramsData = [];
if (is_array($model->params) === true) {
    foreach ($model->params as $key => $param) {
        $paramsData[] = [
            'key' => $key,
            'value' => $param
        ];
    }
}

?>


<div class="box">

    <?php $form = ActiveForm::begin(['id' => 'backend-menu-form']); ?>

    <section class="box-body" id="widget-grid">
        <div class="row">

            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">


                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'parent_id')->dropDownList(
                    [0 => 'Root'] + BackendMenu::find()->select(['name', 'id'])->indexBy('id')->column()
                );
                ?>

                <?= $form->field($model, 'icon') ?>

                <?= $form->field($model, 'translation_category') ?>

                <?= $form->field($model, 'added_by_ext') ?>

                <?= $form->field($model, 'css_class') ?>

                <?= $form->field($model, 'rbac_check') ?>

                <?= $form->field($model, 'sort_order') ?>


            </article>
            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <?= $form->field($model, 'url') ?>

                <?= $form->field($model, 'route') ?>

                <?= $form->field($model, 'params')
                    ->label(false)
                    ->widget(
                        MultipleInput::class,
                        [
                            'columns' => [
                                [
                                    'name' => 'key',
                                    'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                                    'title' => Yii::t('app', 'Key')
                                ],
                                [
                                    'name' => 'value',
                                    'type' => MultipleInputColumn::TYPE_TEXT_INPUT,
                                    'title' => Yii::t('app', 'Value')
                                ]
                            ],
                            'data' => $paramsData
                        ]
                    ) ?>

            </article>
        </div>
        <?= $hasAccess ? FrontendHelper::formSaveButtons(
            $model,
            '/backend-menu/index'
        ) : ''; ?>
    </section>
</div>
<?php ActiveForm::end(); ?>
