<?php
use dosamigos\chartjs\ChartJs;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Рекомендации для Заказчика"; ?>
<div class="row-fluid">
            <div id="sidebar" class="span3">
                <div class="sidebar-nav">
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_admin]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_manager]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget]) ?>
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget_report]) ?>
                </div>
            </div>
            <main id="content" role="main" class="span9">
                <div id="system-message-container">
                </div>

                <div class="item-page" itemscope="" itemtype="http://schema.org/Article">
                    <meta itemprop="inLanguage" content="ru-RU">


                    <div class="page-header">
                        <h2 itemprop="name">Рекомендации для Заказчика</h2>
                    </div>

                    <div itemprop="articleBody">
                        <?= GridView::widget([
                            'dataProvider' => $data_provider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'title',
                                    'header'    => 'Название файла'
                                ],
                                [
                                    'attribute' => 'date_create',
                                    'header'    => 'Дата добавления'
                                ],
                                [
                                    'header'    =>  'Действия',
                                    'format'    => 'html',
                                    'value'     => function ($model, $key, $index, $column){
                                        return
                                            Html::tag('a', 'Скачать',
                                                [
                                                        'href'      => $model['url'],
                                                ]);
                                    }
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>

                <!-- End Content -->
            </main>
</div>
