<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Изменение дезсредства"; ?>
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

                <?php echo $form->field($model, 'title')
                    ->textInput()
                    ->label('Наименование'); ?>

                <?php echo $form->field($model, 'value')
                    ->textInput()
                    ->label('Значение'); ?>

                <?php echo $form->field($model, 'formOfFacility')
                    ->textInput()
                    ->label('Форма средства'); ?>

                <?php echo $form->field($model, 'activeSubstance')
                    ->textInput()
                    ->label('Действующее вещество'); ?>

                <?php echo $form->field($model, 'concentrationOfSubstance')
                    ->textInput()
                    ->label('Концетрация вещества'); ?>

                <?php echo $form->field($model, 'manufacturer')
                    ->textInput()
                    ->label('Производитель'); ?>

                <?php echo $form->field($model, 'termsOfUse')
                    ->textInput()
                    ->label('Условия применения'); ?>

                <?php echo $form->field($model, 'placeOfApplication')
                    ->textInput()
                    ->label('Место применения'); ?>

                <button>Обновить</button>

                <?php ActiveForm::end() ?>

            </div>


            <!-- End Content -->
    </main>
</div>
