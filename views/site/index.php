<?php

/* @var $this \DevGroup\Frontend\monster\MonsterWebView */

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
<?php for($i=0;$i<10;$i++) {
    echo \DevGroup\Frontend\monster\materials\ContentBlocks\ContentBlock005::widget([
        'params' => [
            'title' => 'test',
        ],
        'bemCustomization' => [
            'content005__text' => [
                'utils' => [
                    'one-line--center',
                ],
            ],
            'content005__title' => [
                'utils' => [
                    'one-line--center',
                ],
            ],
            'content005__title-nested' => [
                'mods' => [
                    'foo',
                ],
                'cls' => 'asd',
                'utils' => [
                    'one-line--center',
                ],
            ],
        ],
    ]);
}
?>

