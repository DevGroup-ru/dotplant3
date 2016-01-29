<?php

namespace app\widgets;

use DevGroup\Frontend\monster\MonsterBlockWidget;
use Yii;

class ContentBlock005 extends MonsterBlockWidget
{
    public $title = 'Наши преимущества';
    public $viewFile = 'advantages';

    /**
     * Actual widget rendering function you should implement
     *
     * @return string
     */
    public function runImpl()
    {
        return $this->render(
            $this->viewFile,
            [
                'title' => $this->title,
            ]
        );
    }
}
