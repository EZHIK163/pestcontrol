<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Управление клиентами"; ?>
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
                <h2 itemprop="name">Управление клиентами</h2>
            </div>

            <div itemprop="articleBody">

                <?= GridView::widget([
                    'dataProvider' => $data_provider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'header'    => 'Наименование'
                        ],
                        [
                            'attribute' => 'contacts',
                            'header'    => 'Контакты'
                        ],
                        [
                            'attribute' => 'name_owner',
                            'header'    => 'Владелец'
                        ],
                        [
                            'header'    =>  'Действия',
                            'format'    => 'html',
                            'value'     => function ($model, $key, $index, $column){
                                return
                                    Html::tag('a', 'Изменить',
                                        ['href'  => 'edit-customer?id='.$model['id']])
                                    .'<br/>'.
                                    Html::tag('a', 'Удалить',
                                        ['href'  => 'delete-customer?id='.$model['id']]);
                            }
                        ],

                    ],
                    'pager' => [
                        'class' => '\app\components\MyPagination',
                    ]

                ]); ?>

                <?= Html::a('Добавить клиента', ['/manager-customer/add-customer'], ['class'=>'btn btn-primary']) ?>

            </div>


            <!-- End Content -->
    </main>
</div>
