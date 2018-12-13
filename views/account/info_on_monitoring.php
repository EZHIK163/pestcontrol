<?php
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                        <div class="datepicker" style="display: flex; text-align: center; justify-content: space-around;">
                            <?= $form->field($model, 'dateFrom')->widget(
                                DatePicker::class,
    [
                                // inline too, not bad
                                'inline' => true,
                                'language'  => 'ru',
                                // modify template for custom rendering
                                'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd.mm.yyyy',
                                ]
                            ]
);?>

                            <?= $form->field($model, 'dateTo')->widget(
                                DatePicker::class,
                                [
                                // inline too, not bad
                                'inline' => true,
                                'language'  => 'ru',
                                // modify template for custom rendering
                                'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd.mm.yyyy',
                                ]
                            ]
                            );?>
                        </div>
                        <button>Обновить</button>

                        <?php ActiveForm::end() ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'attribute' => 'n_point',
                                        'label'     => '№ точки'
                                        //'header'    => '№ точки',
                                    ],
                                    [
                                        'attribute' => 'full_name',
                                        'label'     => 'Дезинфектор'
                                        //'header'    => 'Дезинфектор'
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'label'     => 'Статус'
                                       // 'header'    => 'Статус'
                                    ],
                                    [
                                        'attribute' => 'date_check',
                                        'label'     => 'Дата проверки'
                                        //'header'    => 'Дата проверки',
                                    ],
                                    [
                                        'label'     => 'Ссылка на схему',
                                        'format'    => 'html',
                                        'value'     => function ($model, $key, $index, $column) {
                                            if (!empty($model['url'])) {
                                                return
                                                    Html::tag(
                                                        'a',
                                                        'Перейти к схеме',
                                                        ['href'  => $model['url']]
                                                    );
                                            }
                                            return
                                                'нет';
                                        }
                                    ],
                                ]
                            ]); ?>
                </div>

                <!-- End Content -->
            </main>
</div>
