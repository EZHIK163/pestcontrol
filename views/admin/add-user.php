<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Добавления пользователя"; ?>
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
                <h2 itemprop="name">Добавления пользователя</h2>
            </div>

            <div itemprop="articleBody">
                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'username')
                    ->textInput()
                    ->label('Введите логин пользователя'); ?>

                <?php echo $form->field($model, 'password')
                    ->passwordInput()
                    ->label('Введите пароль пользователя'); ?>
                <?php echo $form->field($model, 'role')
                ->dropDownList(
                    $roles,
                    [
                        'prompt' => 'Выберите роль'
                    ]
                ); ?>

                <?php echo $form->field($model, 'id_customer')
                ->dropDownList(
                    $customers,
                    [
                    'prompt' => 'Выберите клиента, к которому будет привязн пользователь'
                    ]
                ); ?>

                <?php echo Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>

            </div>


            <!-- End Content -->
    </main>
</div>
