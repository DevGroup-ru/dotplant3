<?php

namespace app\models;

use DevGroup\TagDependencyHelper\CacheableActiveRecord;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $content
 */
class Page extends \yii\db\ActiveRecord
{
    use TagDependencyTrait;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
        return [
            [['name', 'slug', 'content'], 'required'],
            [['name', 'content'], 'string'],
            [['slug'], 'string', 'max' => 80],
        ];
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
        ];
    }
}
