<?php

use yii\widgets\ActiveForm;

$this->title = "Загрузка файлов"; ?>
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
                        <h2 itemprop="name">Загрузка файлов</h2>
                    </div>

                    <div itemprop="articleBody">

                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                        <?php
                        echo $form->field($model, 'idFileCustomerType')
                            ->dropDownList($file_customer_types, [
                            'prompt' => 'Выберите тип файла...'
                        ])->label('Выберите тип файла');
                        ?>

                        <?php
                        echo $form->field($model, 'idCustomer')->dropDownList($customers, [
                            'prompt' => 'Выберите клиента...'
                        ])->label('Выберите клиента');
                        ?>

                        <?= $form->field($model, 'uploadedFiles[]')
                            ->fileInput(['multiple' => true, 'accept' => '*']) ?>

                        <button>Загрузить</button>

                        <?php ActiveForm::end() ?>

                    </div>


                <!-- End Content -->
            </main>
</div>
