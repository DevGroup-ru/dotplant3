<?php

namespace app\commands;

use DevGroup\FlexIntegration\abstractEntity\mappers\Replace;
use DevGroup\FlexIntegration\abstractEntity\mappers\TrimString;
use DevGroup\FlexIntegration\abstractEntity\mappers\Typecast;
use DevGroup\FlexIntegration\base\MappableColumn;
use DevGroup\FlexIntegration\FlexIntegrationModule;
use DevGroup\FlexIntegration\format\mappers\CSV;
use DevGroup\FlexIntegration\format\reducers\DefaultReducer;
use DevGroup\FlexIntegration\models\BaseTask;
use DotPlant\Store\models\goods\Goods;
use DotPlant\Store\models\goods\Product;
use Yii;
use yii\console\Controller;
use yii\helpers\VarDumper;


class ImportTestController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->multilingual->language_id = 1;

        $repository = $this->flex()->taskRepository;
        $filename = '../../parts_major.txt';

        $taskConfig = [
            'documents' => [
                0 => [
                    'filename' => $filename,
                    'formatMapper' => [
                        'class' => CSV::class,
                        'encoding' => 'CP1251',
                        'delimiter' => "\t",
                        'enclosure' => '',
                        'skipLinesFromTop' => 1,
                        'schema' => [
                            'defaultList' => [
                                'entities' => [
                                    'product' => [
                                        'class' => Product::class,
                                    ],
                                ],
                                'defaultEntity' => 'product',
                                'defaultMappers' => [
                                    TrimString::class,
                                ],
                                'columns' => [
                                    0 => [
                                        'type' => MappableColumn::TYPE_VIRTUAL,
                                    ],
                                    1 => [
                                        'field' => 'sku',
                                        'type' => MappableColumn::TYPE_ATTRIBUTE,
                                        'asSearch' => 'sku',
                                        'asDocumentScopeId' => true,
                                        'skipRowOnEmptyValue' => true,
                                    ],
                                    2 => [
                                        'field' => 'name',
                                        'type' => MappableColumn::TYPE_ATTRIBUTE,
                                        'mappers' => [
//                                            TrimString::class,
                                        ],
                                    ],
                                    3 => [
                                        'field' => '1',
                                        'type' => MappableColumn::TYPE_PRICE,
                                        'mappers' => [
                                            TrimString::class,
                                            [
                                                'class' => Replace::class,
                                                'search' => ',',
                                                'replace' => '.',
                                            ],
                                            [
                                                'class' => Replace::class,
                                                'search' => '/[^0-9\\.]/i',
                                                'replace' => '',
                                                'isRegExp' => true,
                                            ],
                                            Typecast::class,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'formatReducer' => [
                        'class' => DefaultReducer::class,
                    ],
                ],
            ],
        ];

        // create task
        $task = BaseTask::create(BaseTask::TASK_TYPE_IMPORT, $taskConfig);
        return $task->run();
//        $doc = $task->documents[0];
//        $entities = $task->mapDoc($doc, 0);
//        $collections = [];
//        $task->reduceDoc($doc, $entities, $collections);
//        $collections = $task->prioritizeCollections($collections);
//        VarDumper::dump($collections);
    }

    /**
     * @return FlexIntegrationModule
     */
    protected function flex()
    {
        return Yii::$app->getModule('flex');
    }

}