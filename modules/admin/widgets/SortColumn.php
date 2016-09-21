<?php

namespace app\modules\admin\widgets;

use arogachev\sortable\grid\SortableColumn;

/**
 * Class SortColumn
 * @package app\modules\admin\widgets
 */
class SortColumn extends SortableColumn
{
    /** @inheritdoc */
    public $baseUrl = '/admin/sort/';

    /** @inheritdoc */
    public $confirmMove = false;

    /** @inheritdoc */
    public $template = '<span class="sortable-section">{moveWithDragAndDrop}</span>&nbsp;&nbsp;&nbsp;<span class="sortable-section">{currentPosition}</span>';
}
