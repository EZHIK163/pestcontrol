<?php

use unclead\multipleinput\MultipleInput;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Добавления клиента"; ?>
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
                <h2 itemprop="name">Добавление события</h2>
            </div>

            <div itemprop="articleBody">

                <?php if ($model->hasErrors()) { ?>
                    <div class="alert "><a class="close" data-dismiss="alert">×</a><h4 class="alert-heading">Предупреждение</h4>
                        <div>
                            <?php foreach ($model->getErrors() as $error) { ?>
                                <p class="alert-message"><?= $error[0]; ?> </p>
                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <?php
                echo $form->field($model, 'idCustomer')->dropDownList($customers, [
                    'prompt' => 'Выберите клиента...'
                ])->label('Выберите клиента');
                ?>

                <?php
                echo $form->field($model, 'idPointStatus')->dropDownList($point_status, [
                    'prompt' => 'Выберите статус...'
                ])->label('Выберите статус');
                ?>

                <?php
                echo $form->field($model, 'idDisinfector')->dropDownList($disinfectors, [
                    'prompt' => 'Выберите дизинфетора...'
                ])->label('Выберите дизинфетора');
                ?>

                <?php echo $form->field($model, 'numberPoint')
                    ->textInput(['type' => 'number'])
                    ->label('Введите номер точки'); ?>

                <?php echo $form->field($model, 'countPoint')
                    ->textInput(['type' => 'number', 'value' => 0])
                    ->label('Введите количество пойманных вредителей, если их нет, оставьте 0'); ?>

                <button>Добавить</button>

                <?php ActiveForm::end() ?>

            </div>


            <!-- End Content -->
    </main>
</div>
