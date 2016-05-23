<?php

/* @var $this \DotPlant\Monster\MonsterWebView */

use app\helpers\DefaultRouteHelper;
use app\models\Article;
use app\models\Efir;
use app\models\Tag;
use app\models\Tribuna;
use app\widgets\ObjectItemsList;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Главная страница';


?>
    index
<?php /*for($i=0;$i<10;$i++) {
    echo \DotPlant\Monster\materials\BaseMaterial::widget([
        'block' => 'content001',
        'params' => [
            'title' => 'test'.$i,
        ],
        'editableValues' => [
            'content001__title' => 'На лабутенах - '.$i,
            'nested-1' => [
                'content001__title-nested' => 'И в офигительных штанах'.$i,
                'content001__text' => 'Идейные соображения высшего порядка, а также сложившаяся структура организации в значительной степени обуславливает создание систем массового участия',
            ],
        ],
        'uniqueTemplateId' => 'MonsterForTest',
        'bemCustomization' => [
            'content001__title' => [
                'content' => 'test'.$i,
                'utils' => [
                    'one-line--center',
                ],
            ],
        ],
    ]);
}
*/

echo \DotPlant\Monster\MonsterContent::widget([
    'uniqueContentId' => 'site-index',
//    'data' => ['user' => 'Василий Иванович Пупкин'],
    'materials' => [
        [
            'material' => 'core.frontend-monster.content-blocks.content-block-001',
        ],

    ],
]);


