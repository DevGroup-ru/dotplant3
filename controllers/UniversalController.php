<?php

namespace app\controllers;

use DevGroup\Frontend\controllers\FrontendController;
use DevGroup\Frontend\Universal\Core\FillEntities;
use DevGroup\Frontend\Universal\SuperAction;
use DotPlant\Monster\Universal\MainEntity;
use DotPlant\Monster\Universal\ServiceMonsterAction;
use yii;

class UniversalController extends FrontendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => yii\web\ViewAction::class,
                'viewPrefix' => '',
            ],
            'no-entity-test' => [
                'class' => SuperAction::class,
                'actions' => [
                    [
                        'class' => ServiceMonsterAction::class,
                        'serviceTemplateKey' => 'test',
                    ],
                ],
            ],
            'show' => [
                'class' => SuperAction::class,
                'actions' => [
                    [
                        'class' => FillEntities::class,
                        'entitiesMapping' => [
                            'DotPlant\EntityStructure\models\BaseStructure' => 'page',
                        ],
                    ],
                    [
                        'class' => MainEntity::class,
                        'mainEntityKey' => 'page',
                        'defaultTemplateKey' => 'example',
                    ],
                ],
            ],
        ];
    }
}
