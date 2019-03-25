<?php
use app\components\InteractWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "Редактирование схемы точек контроля"; ?>
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
                        <h2 itemprop="name">Переименование схемы точек контроля</h2>
                    </div>

                    <div itemprop="articleBody">
                        <?php if ($isSuccess === true) { ?>
                            <div class="alert "><a class="close" data-dismiss="alert">×</a><h4 class="alert-heading">Результат</h4>
                                <div>
                                    <p class="alert-message">Успешно переименовано</p>
                                </div>
                            </div>
                        <?php } ?>
                        <?php $form = ActiveForm::begin(); ?>

                        <?php echo $form->field($model, 'id')
                            ->textInput(['readonly' => true]); ?>

                        <?php echo $form->field($model, 'title')
                            ->textInput()
                            ->label('Введите наименование схемы'); ?>


                        <?php echo Html::submitButton('Переименовать', ['class' => 'btn btn-primary']); ?>
                        <?php ActiveForm::end(); ?>

                    </div>

                </div>

                <!-- End Content -->
            </main>
</div>
