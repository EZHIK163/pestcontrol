<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Изменение пользователя"; ?>
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
                <h2 itemprop="name">Изменение пользователя</h2>
            </div>

            <div itemprop="articleBody">
                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'id')
                    ->textInput(['readonly' => true]); ?>

                <?php echo $form->field($model, 'name')
                    ->textInput()
                    ->label('Введите наименование клиента'); ?>

                <?php echo $form->field($model, 'id_owner')
                    ->dropDownList($users,
                        [
                            'prompt' => 'Выберите пользователя владельца'
                        ]); ?>


                <?php echo Html::submitButton('Изменить', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>

            </div>


            <!-- End Content -->
    </main>
</div>
