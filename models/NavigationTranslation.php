<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%navigation_translation}}".
 *
 * @property integer $model_id
 * @property integer $language_id
 * @property string $label
 */
class NavigationTranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%navigation_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'language_id', 'label'], 'required'],
            [['model_id', 'language_id'], 'integer'],
            [['label'], 'string', 'max' => 255],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => Navigation::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'model_id' => Yii::t('app', 'Model ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'label' => Yii::t('app', 'Label'),
        ];
    }
}
