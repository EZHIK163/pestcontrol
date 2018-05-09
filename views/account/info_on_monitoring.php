<?php
use dosamigos\chartjs\ChartJs;
use yii\grid\GridView;

$this->title = "Информация по мониторингу {$name_customer}"; ?>
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
                        <h2 itemprop="name"><?= $this->title ?></h2>
                    </div>

                    <div itemprop="articleBody">
                        <div id="spoiler1" class="spoilers">
                        <div class="general_title">За текущий месяц</div>
                        <div class="desc">
                            <?= GridView::widget([
                                'dataProvider' => $data_provider_start_month,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'full_name',
                                        'header'    => 'Дезинфектор'
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'header'    => 'Статус'
                                    ],
                                    [
                                        'attribute' => 'date_check',
                                        'header'    => 'Дата проверки'
                                    ]
                                ]
                            ]); ?>
                        </div>
                        <div class="general_title">За текущий год</div>
                        <div class="desc">
                            <?= GridView::widget([
                                'dataProvider' => $data_provider_start_year,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'full_name',
                                        'header'    => 'Дезинфектор'
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'header'    => 'Статус'
                                    ],
                                    [
                                        'attribute' => 'date_check',
                                        'header'    => 'Дата проверки'
                                    ]
                                ]
                            ]); ?>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- End Content -->
            </main>
</div>
