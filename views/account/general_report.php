<?php
use dosamigos\chartjs\ChartJs;

$this->title = "Отчет общей заселенности объекта вредителями {$name_customer}"; ?>
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
                        <?= ChartJs::widget([
                            'type' => 'doughnut',
                            'data' =>  $data_current_month
                        ]);
                        ?>
                    </div>
                </div>

                <!-- End Content -->
            </main>
</div>
