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
<?php for($i=0;$i<10;$i++) {
    echo \DotPlant\Monster\materials\BaseMaterial::widget([
        'block' => 'content001',
        'params' => [
            'title' => 'test'.$i,
        ],
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
?>

