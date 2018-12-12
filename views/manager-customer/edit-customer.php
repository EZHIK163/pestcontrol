<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;

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

                <?php echo $form->field($model, 'idOwner')
                    ->dropDownList(
                        $users,
                        [
                            'prompt' => 'Выберите пользователя владельца'
                        ]
                    ); ?>
                <?php
                    echo 'Управление контактами<br/>';
                    echo $form->field($model, 'contacts')->widget(MultipleInput::class, [
                        'max' => 10,
                        'columns' => [
                            [
                                'name'  => 'id',
                                'type'  => 'textInput',
                                'title' => 'ID',
                                'defaultValue'  => '0',
                                'options'   => [
                                    'style'     => 'width: 10px',
                                    'readonly'  => true
                                ]
                            ],
                            [
                                'name'  => 'name',
                                'type'  => 'textInput',
                                'title' => 'Наименование',
                                'options'   => [
                                        'style' => 'width: 100px'
                                ]
                            ],
                            [
                                'name'  => 'email',
                                'title' => 'Email',
                                'type'  => 'textInput',
                                'options'   => [
                                    'style' => 'width: 100px',
                                    'type'  => 'email'
                                ]
                            ],
                            [
                                'name'  => 'phone',
                                'title' => 'Номер телефона',
                                'type'  => \yii\widgets\MaskedInput::class,
                                'options'   => [
                                    'class' => 'input-phone',
                                    'mask' => '9-999-999-99-99',
                                ]
                            ]
                        ],
                        'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
                        'cloneButton'       => false
                    ])->label(false);
                ?>


                <?php echo Html::submitButton('Изменить', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>

            </div>


            <!-- End Content -->
    </main>
</div>
