<?php

namespace app\providers;


use app\models\Navigation;
use DotPlant\Monster\DataEntity\DataEntityProvider;

class NavigationProvider extends DataEntityProvider
{
    public $parentId;

    public $regionKey;

    public $materialKey;

    public function pack()
    {
        return [
            'class' => static::class,
            'entities' => $this->entities,
        ];
    }

    public function getEntities(&$actionData)
    {
        return [
            $this->regionKey => [
                $this->materialKey => Navigation::getNavigation($this->parentId)
            ]
        ];
    }

}