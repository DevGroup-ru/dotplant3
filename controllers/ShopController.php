<?php

namespace app\controllers;

use yii;

class ShopController extends yii\web\Controller
{
    public function actions()
    {
        return [
            'list' => [
                'class' => 'SuperAction',
                'actions' => [
                    'Category.Children' => [
                        'limit' => 10
                    ],
                    'Category.Products' => [
                        'defaultLimit' => 10,
                    ],
                ]
            ],
            'show' => [
                'class' => 'SuperAction',
                'entityIn' => 'Product',
                'entityOut' => 'Product',
            ]
        ];
    }

    public function actionSuperAction()
    {
        $inputEntities = [];
        $result = [];
        foreach ($this->actions as $action) {
            $action->run($result, $inputEntities);
        }
        $view = 'fuck';
        return $this->render($view, $result);
    }

    public function CategoryChildren(&$result, &$inputEntities)
    {
        $category = yii\helpers\ArrayHelper::getValue($inputEntities, 'categoryId');
        $result['Category.Children'] = [
            'categories' => $category->children()
        ];
    }

    public function CategoryProducts(&$result, &$inputEntities)
    {
        $result['Category.Products'] = [
            'products' => $category->filter()->paginate()->products(),
        ];
    }
}
