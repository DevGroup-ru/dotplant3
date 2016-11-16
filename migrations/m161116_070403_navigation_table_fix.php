<?php

use app\models\Navigation;
use yii\db\Migration;

class m161116_070403_navigation_table_fix extends Migration
{
    public function up()
    {
        $this->alterColumn(Navigation::tableName(), 'parent_id', $this->integer()->defaultValue(null));
        $this->update(Navigation::tableName(), ['parent_id' => null], ['parent_id' => 0]);
        $this->addForeignKey(
            'fk-navigation-parent_id-navigation-id',
            Navigation::tableName(),
            'parent_id',
            Navigation::tableName(),
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-navigation-parent_id-navigation-id', Navigation::tableName());
        $this->alterColumn(Navigation::tableName(), 'parent_id', $this->integer()->notNull()->defaultValue(0));
    }
}
