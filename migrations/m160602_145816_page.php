<?php

use DotPlant\Monster\DataEntity\StaticContentProvider;
use yii\db\Migration;

class m160602_145816_page extends Migration
{
    public function up()
    {
        $tableOptions = $this->db->driverName === 'mysql'
            ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
            : null;

        $this->insert(
            '{{%template}}',
            [
                'name' => 'Example page layout',
                'key' => 'example',
                'is_layout' => false,
                'packed_json_providers' => json_encode([
                    [
                        'class' => StaticContentProvider::class,
                        'entities' => [
                            'best' => [
                                0 => [
                                    'title' => 'BEST company EVER',
                                    'blocks' => [
                                        [
                                            'name' => [
                                                'href' => '#block1',
                                                'anchor' => 'Block #1',
                                            ],
                                            'content' => 'Lorem ipsum UNO block',
                                        ],
                                        [
                                            'name' => [
                                                'href' => '#block2',
                                                'anchor' => 'Second block',
                                            ],
                                            'content' => 'Lorem ipsum DOS blockos',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]),
            ]
        );
        $templateId = $this->db->lastInsertID;
        $this->insert(
            '{{%template_region}}',
            [
                'template_id' => $templateId,
                'sort_order' => 2,
                'name' => 'Common block',
                'key' => 'best',
                'entity_dependent' => 0,
                'packed_json_content' => json_encode([
                    [
                        'material' => 'core.frontend-monster.content-blocks.content-block-001',
                    ],
                ]),
            ]
        );
        $this->insert(
            '{{%template_region}}',
            [
                'template_id' => $templateId,
                'sort_order' => 1,
                'name' => 'Page content region',
                'key' => 'content',
                'entity_dependent' => 1,
                'packed_json_content' => '[]',
            ]
        );

        $this->createTable(
            '{{%page}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull()->defaultValue(''),
                'slug' => $this->string()->notNull()->defaultValue(''),
                'packed_json_content' => 'LONGTEXT NOT NULL',
                'packed_json_providers' => 'LONGTEXT NOT NULL',
                'template_id' => $this->integer()->notNull()->defaultValue(0),
                'layout_id' => $this->integer()->notNull()->defaultValue(0),
            ],
            $tableOptions
        );
        $this->insert(
            '{{%page}}',
            [
                'name' => 'Example page',
                'slug' => 'example',
                'template_id' => $templateId,
                'packed_json_content' => json_encode([
                    'content' => [
                        [
                            'material' => 'core.frontend-monster.content-blocks.content-block-001',
                        ],
                        [
                            'material' => 'core.frontend-monster.content-blocks.content-block-002',
                        ],
                    ],
                ]),
                'packed_json_providers' => json_encode([
                    [
                        'class' => StaticContentProvider::class,
                        'entities' => [
                            'content' => [
                                0 => [
                                    'title' => 'First block title',
                                    'blocks' => [],
                                ],
                                1 => [
                                    'title' => 'Second block',
                                    'blocks' => [
                                        [
                                            'name' => [
                                                'anchor' => 'Namo1',
                                                'href' => '#1',
                                            ],
                                            "img" => [
                                                "src" => "http://lorempixel.com/200/300/cats",
                                                "alt" => "Image ALT #1",
                                            ],
                                            'content' => 'number one bla bla bla bla 1',
                                        ],
                                        [
                                            'name' => [
                                                'anchor' => 'Namo2',
                                                'href' => '#2',
                                            ],
                                            "img" => [
                                                "src" => "http://lorempixel.com/200/300/cats",
                                                "alt" => "Image ALT #1",
                                            ],
                                            'content' => 'number 2 bla bla bla bla 1',
                                        ],
                                        [
                                            'name' => [
                                                'anchor' => 'Namo3',
                                                'href' => '#3',
                                            ],
                                            "img" => [
                                                "src" => "http://lorempixel.com/200/300/cats",
                                                "alt" => "Image ALT #1",
                                            ],
                                            'content' => 'Three brown foxes jumped over the lazy dog',
                                        ],
                                        [
                                            'name' => [
                                                'anchor' => 'Namo1',
                                                'href' => '#1',
                                            ],
                                            "img" => [
                                                "src" => "http://lorempixel.com/200/300/cats",
                                                "alt" => "Image ALT #1",
                                            ],
                                            'content' => 'Lorem ipsum dolor sit amet',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]),
            ]
        );
    }

    public function down()
    {
        $this->dropTable('{{%page}}');
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
