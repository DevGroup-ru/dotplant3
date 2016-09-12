<?php

namespace app\controllers;

use DevGroup\Frontend\controllers\FrontendController;
use DevGroup\Frontend\Universal\Core\FillEntities;
use DevGroup\Frontend\Universal\SuperAction;
use DotPlant\Monster\Universal\MainEntity;
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
