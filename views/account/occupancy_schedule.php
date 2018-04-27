<?php
use dosamigos\chartjs\ChartJs;
use dosamigos\datepicker\DatePicker;

$this->title = "График заселенности объекта"; ?>
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
                        <h2 itemprop="name">График заселенности объекта</h2>
                    </div>

                    <div itemprop="articleBody">

     

                        <p><?= ChartJs::widget([
                            'type' => 'bar',
                            'data' => $current_year
                        ]);
                        ?></p>
                        <p><?= ChartJs::widget([
                        'type' => 'bar',
                        'data' => $previous_year
                    ]);
                    ?></p>
                        <p><?= ChartJs::widget([
                                'type' => 'bar',
                                'data' => $previous_previous_year
                            ]);
                            ?></p>
                    </div>
                    </div>

                <!-- End Content -->
            </main>
</div>
