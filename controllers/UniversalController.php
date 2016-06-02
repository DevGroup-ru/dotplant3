<?php

namespace app\controllers;

use DevGroup\Frontend\Universal\Core\FillEntities;
use DevGroup\Frontend\Universal\SuperAction;
use DotPlant\Monster\Universal\MainEntity;
use DotPlant\Monster\Universal\MaterializedAttributes;
use yii;

class UniversalController extends yii\web\Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => yii\web\ViewAction::class,
                'viewPrefix' => '',
            ],
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
                        'class' => MainEntity::class,
                        'mainEntityKey' => 'page',
                        'defaultTemplateKey' => 'example',
                    ],
                    // deprecated!!!
//                    [
//                        'class' => MaterializedAttributes::class, 
//                        'entities' => [
//                            [
//                                'entity' => 'page',
//                                'attributes' => ['content',]
//                            ],
//                        ],
//                    ],
                ],
            ],
        ];
    }
}
