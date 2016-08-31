<?php

namespace app\models;

use arogachev\sortable\behaviors\numerical\ContinuousNumericalSortableBehavior;
use DevGroup\DataStructure\behaviors\PackedJsonAttributes;
use DevGroup\Entity\traits\EntityTrait;
use DevGroup\TagDependencyHelper\CacheableActiveRecord;
use DevGroup\TagDependencyHelper\TagDependencyTrait;
use Yii;
use yii\data\ActiveDataProvider;
use yii\caching\TagDependency;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "backend_menu".
 * BackendMenu stores tree of navigation in backend
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name Name of item - will be translated against .translation_category attribute
 * @property string url
 * @property array $route Route or absolute URL to item
 * @property string $icon Icon for menu item
 * @property string $added_by_ext Identifier of extension that added this menu item
 * @property string $css_class CSS class attribute for menu item
 * @property string $translation_category Translation category for Yii::t()
 * @property integer $sort_order
 * @property string $rbac_check
 */
class BackendMenu extends ActiveRecord
{
    use TagDependencyTrait;
    use EntityTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%backend_menu}}';
    }

    /**
     * @var array
     */
    private $rules = [
        [['parent_id', 'sort_order'], 'integer'],
        [['name'], 'required'],
        [['rbac_check'], 'string', 'max' => 64],
        [['translation_category'], 'default', 'value' => 'app'],
        [['added_by_ext'], 'default', 'value' => 'core'],
        [
            ['name', 'icon', 'added_by_ext', 'css_class', 'translation_category', 'route', 'url'],
            'string',
            'max' => 255
        ],
        ['sort_order', 'default', 'value' => 0],
        ['params', 'safe'],
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'CacheableActiveRecord' => [
                'class' => CacheableActiveRecord::class,
            ],
            'ContinuousNumericalSortableBehavior' => [
                'class' => ContinuousNumericalSortableBehavior::class,
                'sortAttribute' => 'sort_order'
            ],
            'PackedJsonAttributes' => [
                'class' => PackedJsonAttributes::class,
            ],
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
            'name' => Yii::t('app', 'Name'),
            'route' => Yii::t('app', 'Route'),
            'icon' => Yii::t('app', 'Icon'),
            'added_by_ext' => Yii::t('app', 'Added by extension'),
            'sort_order' => Yii::t('app', 'Sort order'),
            'rbac_check' => Yii::t('app', 'Rbac role'),
            'translation_category' => Yii::t('app', 'Translation Category'),
        ];
    }

    /**
     * Search support for GridView and etc.
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query \yii\db\ActiveQuery */
        $query = self::find()
            ->where(['parent_id' => $this->parent_id]);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );
        if (!($this->load($params))) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'icon', $this->icon]);
        $query->andFilterWhere(['like', 'added_by_ext', $this->added_by_ext]);
        return $dataProvider;
    }

    /**
     * @return array
     */
    public static function getBackendMenu()
    {
        $cacheKey = 'BackendMenu:menuItems:' . Yii::$app->language;

        if (false === $items = Yii::$app->cache->get($cacheKey)) {
            $items = (array)self::getTree(0);
            Yii::$app->cache->set(
                $cacheKey,
                $items,
                86400,
                new TagDependency(['tags' => self::commonTag()])
            );
        }
        self::checkPermissions($items);
        return $items;
    }

    /**
     * @param array $items
     */
    private static function checkPermissions(&$items)
    {
        foreach ($items as &$item) {
            if (empty($item['rbac_check']) === false) {
                $item['visible'] = Yii::$app->user->can($item['rbac_check']);
                unset($item['rbac_check']);
            }
            if (empty($item['items']) === false) {
                self::checkPermissions($item['items']);
            }
        }
    }

    /**
     * Returns all available to logged user BackendMenu items in yii\widgets\Menu acceptable format
     * @return array Tree representation of items
     */
    private static function getTree($parent_id = 0)
    {
        $items = [];
        foreach (self::find()->where(['parent_id' => $parent_id])->orderBy('sort_order')->asArray()->all() as $item) {
            $translation_category =
                empty($item['translation_category']) === false
                && isset(Yii::$app->i18n->translations[$item['translation_category']]) === true ?
                    $item['translation_category'] :
                    'app';

            $url = '#';
            if (empty($item['url']) === false) {
                $url = $item['url'];
            } elseif (empty($item['route']) === false) {
                $url = [$item['route']];
                if (empty($item['packed_json_params']) === false) {
                    $url = ArrayHelper::merge($url, Json::decode($item['packed_json_params']));
                }
            }
            $items[] = [
                'label' => Yii::t($translation_category, $item['name']),
                'url' => $url,
                'icon' => $item['icon'],
                'options' => [
                    'class' => $item['css_class']
                ],
                'rbac_check' => $item['rbac_check'],
                'items' => self::getTree($item['id'])
            ];
        }
        return $items;
    }
}
