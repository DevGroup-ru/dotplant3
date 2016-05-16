<?php

namespace app\controllers;

use DevGroup\Frontend\Universal\Core\FillEntities;
use DevGroup\Frontend\Universal\SuperAction;
use DotPlant\Monster\Universal\MaterializedAttributes;
use yii;

class UniversalController extends yii\web\Controller
{
    public function actions()
    {
        return [
            'show' => [
                'class' => SuperAction::class,
                'actions' => [
                    [
                        'class' => FillEntities::class,
                        'entitiesMapping' => [
                            'app\models\Page' => 'page',
                        ],
                    ],
                    [
                        'class' => MaterializedAttributes::class,
                        'entities' => [
                            [
                                'entity' => 'page',
                                'attributes' => ['content',]
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
