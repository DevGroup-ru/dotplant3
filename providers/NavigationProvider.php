<?php

namespace app\providers;

use app\models\Navigation;
use DotPlant\Monster\DataEntity\DataEntityProvider;

/**
 * Class NavigationProvider
 * @package app\providers
 */
class NavigationProvider extends DataEntityProvider
{
    /**
     * @var int the menu parent id
     */
    public $parentId;

    /**
     * @var string the region key
     */
    public $regionKey = 'header';

    /**
     * @var string the material key
     */
    public $materialKey = 'mainMenu';

    /**
     * @var string the block key
     */
    public $blockKey = 'menuItems';

    /**
     * @var bool whether to get only visible menu items
     */
    public $visibleOnly = true;

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
        $this->entities = [
            $this->regionKey => [
                $this->materialKey => [
                    $this->blockKey => Navigation::getNavigation($this->parentId, $this->visibleOnly),
                ]
            ]
        ];
        return $this->entities;
    }
}