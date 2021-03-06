<?php
use dosamigos\chartjs\ChartJs;
use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;

$this->title = "Отчет по точкам контроля  {$name_customer}"; ?>
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
                        <p><span style="font-size: 14pt;">Информация за выбранный период обслуживания:</span></p>
                        <p><?= ChartJs::widget([
                                'type' => 'doughnut',
                                'data' => $data
                            ]);
                            ?></p>
                        <hr />
                        <?php if ($isHeineken) { ?>
                        <a href="<?=\Yii::$app->urlManager->createAbsoluteUrl(['/'])?>report/report-points-heineken">Отчет heineken</a><br/>
                        <?php } ?>
                        <a href="<?=\Yii::$app->urlManager->createAbsoluteUrl(['/'])?>report/report-points-to-excel">Выгрузить отчет по мониторингу</a><br/>
                        <a href="<?=\Yii::$app->urlManager->createAbsoluteUrl(['/'])?>report/report-points-to-print">Выгрузить отчет на печать</a>

                    </div>
                    </div>

                <!-- End Content -->
            </main>
</div>
