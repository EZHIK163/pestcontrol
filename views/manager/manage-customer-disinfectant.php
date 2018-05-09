<?php

use unclead\multipleinput\MultipleInput;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Выбор дезсредств для клиента"; ?>
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

                <?php $form = ActiveForm::begin(); ?>
                <?php echo $form->field($model, 'disinfectants')->widget(MultipleInput::class, [
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
                            'name'  => 'disinfectant',
                            'type'  => 'textInput',
                            'title' => 'Дезсредство',
                            'options'   => [
                                'style' => 'width: 100px',
                                'readonly'  => true
                            ]
                        ],
                        [
                            'name'  => 'is_set',
                            'title' => 'Установка',
                            'type'  => 'checkBox',
                            'options'   => [
                                'style' => 'width: 100px',
                            ]
                        ]
                    ],
                    'addButtonPosition' => false,
                    'cloneButton'       => false,
                    'extraButtons'   => false
                ])->label(false);

                ?>

                <?php echo Html::submitButton('Изменить', ['class' => 'btn btn-primary']); ?>
                <?php ActiveForm::end(); ?>
            </div>


            <!-- End Content -->
    </main>
</div>
