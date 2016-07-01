<?php

use app\models\Page;
use DevGroup\DataStructure\helpers\PropertiesTableGenerator;
use yii\db\Migration;

class m160630_132353_add_model_to_dst extends Migration
{
    public function up()
    {
        PropertiesTableGenerator::getInstance()->generate(Page::class);
    }

    public function down()
    {
        PropertiesTableGenerator::getInstance()->drop(Page::class);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
