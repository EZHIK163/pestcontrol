<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = "Управление рекомендациями"; ?>
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
                        <h2 itemprop="name">Управление рекомендациями</h2>
                    </div>

                    <div itemprop="articleBody">
                        <?php Pjax::begin(); ?>
                        <?= GridView::widget([
                            'dataProvider' => $data_provider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'title',
                                    'header'    => 'Название файла'
                                ],
                                [
                                    'attribute' => 'customer',
                                    'header'    => 'Клиент'
                                ],
                                [
                                    'attribute' => 'date_create',
                                    'header'    => 'Дата добавления'
                                ],
                                [
                                    'header'    =>  'Действия',
                                    'format'    => 'raw',
                                    'value'     => function ($model, $key, $index, $column){
                                            return
                                            //Html::tag('a', 'Изменить',
                                            //    ['href'  => 'edit-recommendation?id='.$model['id_file_customer']])
                                            //.'<br/>'.
                                            Html::tag('a', 'Удалить',
                                                ['href'  => 'delete-recommendation?id='.$model['id_file_customer']])
                                                .'<br/>'.
                                            Html::tag('a', 'Скачать',
                                                [
                                                    'href'      => $model['url'],
                                                    'target'    => '_blank',
                                                    'data-pjax'=>"0"
                                                ]);
                                    }
                                ],
                            ],
                            'pager' => [
                                'class' => '\app\components\MyPagination',
                            ]
                        ]); ?>
                        <?php Pjax::end(); ?>

                    </div>


                <!-- End Content -->
            </main>
</div>
