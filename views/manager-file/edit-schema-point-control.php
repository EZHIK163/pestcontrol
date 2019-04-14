<?php
use app\components\InteractWidget;
use yii\helpers\Html;

$this->title = "Редактирование схемы точек контроля " . $title; ?>
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
                        <h2 itemprop="name"> <?= $this->title ?></h2>
                    </div>

                    <div id= "main_div2" itemprop="articleBody">

                        <div id="main_div" class="edit-scheme-zone">
                        <?= InteractWidget::widget(['id'   => $idSchemaPointControl]);
                        ?>
                        </div>
                        <div class="manage-scheme">
                            <?= Html::button(
                                'Сохранить точки',
                                [
                                    'id'        => 'myButton',
                                    'class'     => 'btn btn-primary',
                                    'onclick'   => 'savePoint()',
                                ]
                            ); ?>
                            <?= Html::button(
                                'Добавить точку',
                                [
                                    'id'        => 'myButton',
                                    'class'     => 'btn btn-primary',
                                    'onclick'   => 'addPoint()',
                                ]
                            ); ?>
                        </div>
                    </div>

                </div>

                <!-- End Content -->
            </main>
</div>
