<?php

namespace app\providers;

use DotPlant\Monster\DataEntity\DataEntityProvider;

/**
 * Class BreadcrumbsProvider
 * @package app\providers
 */
class BreadcrumbsProvider extends DataEntityProvider
{
    /**
     * @var string the region key
     */
    public $regionKey = 'content';

    /**
     * @var string the material key
     */
    public $materialKey = 'breadcrumbs';

    /**
     * @var string the block key
     */
    public $blockKey = 'breadcrumbsList';

    /**
     * @inheritdoc
     */
    public function pack()
    {
        return [
            'class' => static::class,
            'entities' => $this->entities,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getEntities(&$actionData)
    {
        if (isset($actionData->controller->view->params['breadcrumbs'])) {
            $breadcrumbs = $actionData->controller->view->params['breadcrumbs'];
            if (count($breadcrumbs) > 0) {
                $last = array_pop($breadcrumbs);
                unset($last['url']);
                $breadcrumbs[] = $last;
            }
        } else {
            $breadcrumbs = [];
        }
        $this->entities = [
            $this->regionKey => [
                $this->materialKey => [
                    $this->blockKey =>
                        $breadcrumbs,
                ],
            ]
        ];
        return $this->entities;
    }
}
