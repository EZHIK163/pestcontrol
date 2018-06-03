<?php
use dosamigos\chartjs\ChartJs;
use dosamigos\datepicker\DatePicker;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Отчет по дезсредствам  {$name_customer}"; ?>
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
                            <?= $form->field($model, 'date_from')->widget(
                                DatePicker::class, [
                                // inline too, not bad
                                'inline' => true,
                                'language'  => 'ru',
                                // modify template for custom rendering
                                'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd.mm.yyyy',
                                ]
                            ]);?>

                            <?= $form->field($model, 'date_to')->widget(
                                DatePicker::class, [
                                // inline too, not bad
                                'inline' => true,
                                'language'  => 'ru',
                                // modify template for custom rendering
                                'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd.mm.yyyy',
                                ]
                            ]);?>
                        </div>
                        <button>Обновить</button>

                        <?php ActiveForm::end() ?>

                        <p><span style="font-family: impact,chicago; font-size: 14pt;"><span style="font-family: arial,helvetica,sans-serif;">За выбранный период:</span></span></p>
                        <?= GridView::widget([
                            'dataProvider' => $data_provider,
                            'columns' => array_merge([
                                ['class' => 'yii\grid\SerialColumn'],
                            ], $setting_column)
                        ]); ?>

                        <a href="<?=\Yii::$app->urlManager->createAbsoluteUrl(['/'])?>report/report-disinfectant?from_datetime=<?=$model->date_from?>&to_datetime=<?=$model->date_to?>">Экспорт в Excel</a>

                    </div>
                    </div>

                <!-- End Content -->
            </main>
</div>
