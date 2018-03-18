<?php
use dosamigos\chartjs\ChartJs;
$this->title = "Информация по мониторингу"; ?>
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
                        <h2 itemprop="name">Информация по мониторингу</h2>
                    </div>

                    <div itemprop="articleBody">
                        <div id="spoiler1" class="spoilers">
                        <div class="title active">За текущий месяц</div>
                        <div class="desc">

                        </div>
                        <div class="title active">За текущий год</div>
                        <div class="desc">
                        </div>
                        </div>
                    </div>
                </div>

                <!-- End Content -->
            </main>
</div>
