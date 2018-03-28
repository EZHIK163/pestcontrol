<?php
use app\components\InteractWidget;
use yii\helpers\Html;

$this->title = "Схемы точек контроля"; ?>
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
                        <h2 itemprop="name">Схемы точек контроля</h2>
                    </div>

                    <div id="main_div" itemprop="articleBody">
                        <?= InteractWidget::widget();
                        ?>
                        <?= Html::button(
                        'Сохранить точки',
                        [
                        'id'        => 'myButton',
                        'class'     => 'btn btn-primary',
                        'onclick'   => 'savePoint()',
                        ]
                        ); ?>
                    </div>

                </div>

                <!-- End Content -->
            </main>
</div>
