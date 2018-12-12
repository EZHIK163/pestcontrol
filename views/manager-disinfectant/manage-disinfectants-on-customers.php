<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Управление дезсредствами клиентов"; ?>
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

                <?= GridView::widget([
                    'dataProvider' => $data_provider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'header'    => 'Клиент'
                        ],
                        [
                            'attribute' => 'disinfectants',
                            'header'    => 'Дезсредства'
                        ],
                        [
                            'header'    =>  'Действия',
                            'format'    => 'html',
                            'value'     => function ($model, $key, $index, $column) {
                                return
                                    Html::tag(
                                        'a',
                                        'Изменить',
                                        ['href'  => 'manage-customer-disinfectant?id='.$model['id']]
                                    );
                            }
                        ],

                    ],
                    'pager' => [
                        'class' => '\app\components\MyPagination',
                    ]

                ]); ?>

            </div>


            <!-- End Content -->
    </main>
</div>
