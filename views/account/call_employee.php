<?php
$this->title = "Вызов бригады пестконтроля {$name_customer}";

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

?>
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

                        <div class="contact-form">
                            <?php $form = ActiveForm::begin(); ?>
                            <legend>Отправить сообщение. Все поля, отмеченные звездочкой, являются обязательными.</legend>
                            <?php echo $form->field($model, 'fullName')
                                ->textInput()
                                ->label('Имя<span class="star">&#160;*</span>'); ?>

                            <?php echo $form->field($model, 'email')
                                ->textInput()
                                ->label('Email<span class="star">&#160;*</span>'); ?>

                            <?php echo $form->field($model, 'title')
                                ->textInput()
                                ->label('Тема<span class="star">&#160;*</span>'); ?>

                            <?php echo $form->field($model, 'message')
                                ->textInput()
                                ->label('Сообщение<span class="star">&#160;*</span>'); ?>

                            <?php echo $form->field($model, 'isSendCopy')
                                ->checkbox([
                                    'label' => 'Отправить копию этого сообщения на ваш адрес',
                                    'labelOptions' => [
                                        'style' => 'padding-left:20px;'
                                    ],
                                ]); ?>

                            <?php echo Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary']); ?>
                            <?php ActiveForm::end(); ?>

                        <h3>Дополнительная информация</h3>
                        <div class="contact-miscinfo">
					<span class="contact-misc">
						<span style="color: #ff0000;">
                            <strong>
                                <span style="font-size: 12pt;">Обязательно указывайте город нахождения предприятия!</span>
                            </strong>
                        </span>

                    </span>
                        </div>



                    </div>


                <!-- End Content -->
            </main>
</div>
