<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Управление событиями"; ?>
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
                <h2 itemprop="name"><?=$this->title?></h2>
            </div>

            <div itemprop="articleBody">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <?php
                echo $form->field($model, 'idCustomer')->dropDownList($customers, [
                    'prompt' => 'Выберите клиента...'
                ])->label('Выберите клиента');
                ?>

                <button>Обновить</button>

                <?= Html::a('Добавить событие', ['/manager-event/add-event'], ['class'=>'btn btn-primary']) ?>

                <?php ActiveForm::end() ?>

                <?= GridView::widget([
                    'dataProvider' => $data_provider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'header'    => 'Клиент'
                        ],
                        [
                            'attribute' => 'point_status',
                            'header'    => 'Статус точки'
                        ],
                        [
                            'attribute' => 'id_internal',
                            'header'    => 'Номер точки'
                        ],
                        [
                            'attribute' => 'count',
                            'header'    => 'Кол-во'
                        ],
                        [
                            'attribute' => 'datetime',
                            'header'    => 'Дата и время'
                        ],
                        [
                            'header'    =>  'Действия',
                            'format'    => 'html',
                            'value'     => function ($model, $key, $index, $column) {
                                return
                                    Html::tag(
                                        'a',
                                        'Изменить',
                                        ['href'  => 'edit-event?id='.$model['id']]
                                    )
                                    .'<br/>'.
                                    Html::tag(
                                        'a',
                                        'Удалить',
                                        ['href'  => 'delete-event?id='.$model['id']]
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
