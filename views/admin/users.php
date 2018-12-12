<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = "Управление пользователями"; ?>
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
                <h2 itemprop="name">Управление пользователями</h2>
            </div>

            <div itemprop="articleBody">

                <?= GridView::widget([
                    'dataProvider' => $data_provider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'username',
                            'header'    => 'Логин'
                        ],
                        [
                            'attribute' => 'customer',
                            'header'    => 'Привязан к клиенту'
                        ],
                        [
                            'attribute' => 'role',
                            'header'    => 'Роль'
                        ],
                        [
                            'header'    =>  'Действия',
                            'format'    => 'html',
                            'value'     => function ($model, $key, $index, $column) {
                                return
                                    Html::tag(
                                        'a',
                                        'Изменить',
                                        ['href'  => 'edit-user?id='.$model['id']]
                                    )
                                    .'<br/>'.
                                    Html::tag(
                                        'a',
                                        'Удалить',
                                        ['href'  => 'delete-user?id='.$model['id']]
                                    );
                            }
                        ],
                    ],

                ]); ?>

                <?= Html::a('Добавить пользователя', ['/admin/add-user'], ['class'=>'btn btn-primary']) ?>

            </div>


            <!-- End Content -->
    </main>
</div>
