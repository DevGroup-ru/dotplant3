<?php

use DotPlant\Content\models\Page;
use DotPlant\EntityStructure\models\BaseStructure;
use DotPlant\EntityStructure\models\Entity;
use DevGroup\Multilingual\models\Context;
use yii\db\Migration;

class m160912_115202_dotplant_core_add_demo_page extends Migration
{
    public function up()
    {
        $entityId = Entity::getEntityIdForClass(Page::class);
        $contexts = Context::find()->all();
        foreach ($contexts as $context) {
            $this->insert(
                BaseStructure::tableName(),
                [
                    'context_id' => $context->id,
                    'entity_id' => $entityId,
                ]
            );
            $id = $this->db->lastInsertID;
            foreach ($context->languages as $language) {
                $this->insert(
                    BaseStructure::getTranslationTableName(),
                    [
                        'model_id' => $id,
                        'language_id' => $language->id,
                        'name' => 'name',
                        'slug' => 'universal',
                    ]
                );
                $this->insert(
                    \DotPlant\Content\models\PageExtended::tableName(),
                    [
                        'model_id' => $id,
                        'language_id' => $language->id,
                        'packed_json_content' => '{"content":{"p01":{"material":"core.frontend-monster.content-blocks.content-block-001"},"p02":{"material":"core.frontend-monster.content-blocks.content-block-002"}}}',
                        'packed_json_providers' => '[]',
//                        'layout_id' => '1',
                    ]
                );
            }
        }
    }

    public function down()
    {
        $ids = (new \yii\db\Query())->select('model_id')
            ->from(BaseStructure::getTranslationTableName())
            ->where(['slug' => 'universal'])
            ->column();
        $this->delete(
            BaseStructure::tableName(),
            ['id' => $ids]
        );
    }
}
