<?php

namespace app\models;

use DevGroup\DataStructure\behaviors\PackedJsonAttributes;
use DevGroup\Entity\traits\EntityTrait;
use DevGroup\Entity\traits\SoftDeleteTrait;
use DevGroup\Multilingual\behaviors\MultilingualActiveRecord;
use DevGroup\Multilingual\traits\MultilingualTrait;
use DevGroup\TagDependencyHelper\CacheableActiveRecord;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%navigation}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $url
 * @property integer $structure_id
 * @property array $params
 * @property string $css_class
 * @property string $rbac_check
 * @property integer $sort_order
 * @property integer $active
 * @property integer $is_deleted
 * @property string $label
 */
class Navigation extends \yii\db\ActiveRecord
{

    use MultilingualTrait;
    use TagDependencyTrait;
    use EntityTrait;
    use SoftDeleteTrait;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'multilingual' => [
                'class' => MultilingualActiveRecord::class,
                'translationPublishedAttribute' => false,
            ],
            'CacheableActiveRecord' => [
                'class' => CacheableActiveRecord::class,
            ],
            'PackedJsonAttributes' => [
                'class' => PackedJsonAttributes::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%navigation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order', 'active', 'is_deleted', 'context_id'], 'required'],
            [['parent_id', 'structure_id', 'sort_order', 'active', 'context_id'], 'integer'],
            [['url', 'css_class', 'rbac_check'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'url' => Yii::t('app', 'Url'),
            'structure_id' => Yii::t('app', 'Structure ID'),
            'params' => Yii::t('app', 'Params'),
            'css_class' => Yii::t('app', 'Css Class'),
            'rbac_check' => Yii::t('app', 'Rbac Check'),
            'sort_order' => Yii::t('app', 'sort_order'),
            'active' => Yii::t('app', 'Active'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
        ];
    }

    public function search($parent_id, $params, $showHidden = false)
    {
        $query = self::find();
        $query->where([
            'parent_id' => $parent_id
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $dataProvider->sort->attributes['label'] = [
            'asc' => ['navigation_translation.label' => SORT_ASC],
            'desc' => ['property_group_translation.label' => SORT_DESC],
        ];

        if (!($this->load($params))) {
            if ($showHidden === false) {
                $this->is_deleted = 0;
                $query->andWhere(['is_deleted' => $this->is_deleted]);
            }
            return $dataProvider;
        }


        // perform filtering
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'sort_order', $this->sort_order]);


        $query->andFilterWhere(['parent_id' => $this->parent_id]);
        $query->andFilterWhere(['structure_id' => $this->structure_id]);
        $query->andFilterWhere(['is_deleted' => $this->is_deleted]);

        // filter by multilingual field
        $query->andFilterWhere(['like', 'property_translation.label', $this->label]);


        return $dataProvider;
    }
}
