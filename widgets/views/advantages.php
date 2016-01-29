<?php
/** @var $this \DevGroup\Frontend\monster\MonsterWebView */
/** @var $title string */
use yii\helpers\Html;
?>
<div class="m-container">
<?php
$this->bemBlock('content005', [], 'm-row g__one-line--top-bottom');
    $this->bemElement('title', [], 'g__one-line--center g__no-margin-top');

        echo Html::encode($title);

    $this->endBemElement();
    for ($i=0; $i<6; $i++) {
        $this->bemElement('nested');
            ?>
        <span class="content005__icon icon-project-color-001-consultation">
        <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span>
        </span>
        <?php
            $this->bemElement('text-wrap', [], '', 'content005');
                $this->bemElement('title-nested', [], '', 'content005');
                    echo "Классное преимущество, всем нравится";
                $this->endBemElement();
                $this->bemElement('text', [], '', 'content005');
                    echo "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos suscipit officia quod quam illo in et beatae amet fuga, laudantium!";
                $this->endBemElement();
            $this->endBemElement();
        $this->endBemElement();
    }
?>

<?php
$this->endBemBlock();
?>
</div>