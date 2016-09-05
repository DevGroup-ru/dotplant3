<?php
use app\models\Navigation;
use DevGroup\AdminUtils\FrontendHelper;
use DevGroup\Multilingual\models\Context;
use DevGroup\Multilingual\widgets\MultilingualFormTabs;
use DotPlant\EntityStructure\models\BaseStructure;
use kartik\select2\Select2;
use unclead\widgets\MultipleInput;
use unclead\widgets\MultipleInputColumn;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @var $model Navigation
 * @var $hasAccess bool
 * @var $this \yii\web\View
 */
$this->title = Yii::t('app', 'Edit navigation item');

$this->params['breadcrumbs'][] = [
    'url' => ['/navigation/index'],
    'label' => Yii::t('app', 'Navigation items')
];
if (($model->parent_id > 0)
    && (null !== $parent = Navigation::findOne($model->parent_id))
) {
    $this->params['breadcrumbs'][] = [
        'url' => [
            '/navigation/index',
            'id' => $parent->id,
            'parent_id' => $parent->parent_id
        ],
        'label' => $parent->label
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

$parentsArray = [0 => 'Root'];

$parentItems = Navigation::find()->orderBy('parent_id')->asArray()->all();

foreach ($parentItems as $item) {
    if (isset($item['defaultTranslation']['label'])) {
        $parentsArray[$item['id']] = $item['defaultTranslation']['label'];
    }
}


$structuresArray = [];


?>


<div class="box">

    <?php $form = ActiveForm::begin(['id' => 'navigation-form']); ?>

    <section class="box-body" id="widget-grid">
        <div class="row">

            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <?= $form->field($model, 'parent_id')->widget(Select2::class, ['data' => $parentsArray]); ?>

                <?= $form->field($model, 'css_class') ?>

                <?= $form->field($model, 'rbac_check') ?>

                <?= $form->field($model, 'sort_order') ?>

            </article>
            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                <?= $form->field($model, 'context_id')->dropDownList(
                    ArrayHelper::map(
                        Context::find()->asArray()->all(),
                        'id',
                        'name'
                    )
                ); ?>

                <?= $form->field($model, 'url') ?>

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
        <div class="row">
            <?= MultilingualFormTabs::widget([
                'model' => $model,
                'childView' => __DIR__ . DIRECTORY_SEPARATOR . '_navigation-multilingual.php',
                'form' => $form,
            ]) ?>
        </div>
        <?= $hasAccess ? FrontendHelper::formSaveButtons(
            $model,
            '/navigation/index'
        ) : ''; ?>
    </section>
</div>
<?php ActiveForm::end(); ?>
