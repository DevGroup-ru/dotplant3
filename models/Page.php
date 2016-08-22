<?php

namespace app\models;

use DevGroup\DataStructure\traits\PropertiesTrait;
use DevGroup\TagDependencyHelper\CacheableActiveRecord;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
use DotPlant\Monster\Universal\MonsterEntityTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string  $name
 * @property string  $slug
 * @property array   $content
 * @property array   $providers
 * @property integer $template_id
 */
class Page extends \yii\db\ActiveRecord
{
    use TagDependencyTrait;
    use MonsterEntityTrait;
    use PropertiesTrait;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // other behaviors
            'properties' => [
                'class' => '\DevGroup\DataStructure\behaviors\HasProperties',
                'autoFetchProperties' => true,
            ],
            'CacheableActiveRecord' => [
                'class' => CacheableActiveRecord::className(),
            ],
            'PackedJsonAttributes' => [
                'class' => \DevGroup\DataStructure\behaviors\PackedJsonAttributes::className(),
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            [
                [['template_id'], 'integer'],
                [['name', 'slug'], 'required'],
                [['name', 'slug'], 'string'],
                [['content', 'providers',], 'safe',],
                [['slug'], 'string', 'max' => 80],
            ],
            $this->propertiesRules()
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'content' => 'Content',
            'providers' => 'Providers',
        ];
    }
}
