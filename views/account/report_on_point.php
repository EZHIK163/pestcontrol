<?php
use dosamigos\chartjs\ChartJs;
$this->title = "Отчет по точкам контроля"; ?>
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
                        <h2 itemprop="name">Отчет по точкам контроля</h2>
                    </div>

                    <div itemprop="articleBody">
                        <p><span style="font-size: 14pt;">Информация за весь период обслуживания:</span></p>
                        <p><?= ChartJs::widget([
                                'type' => 'doughnut',
                                'data' => $data_all_periods
                            ]);
                            ?></p>
                        <hr />
                        <p><span style="font-size: 14pt;">Информация за текущий месяц:</span></p>
                        <p><?= ChartJs::widget([
                                'type' => 'doughnut',
                                'data' => $data_current_month
                            ]);
                            ?></p>
                        <hr />
                        <p><span style="font-size: 14pt;">Отчет по точкам<br /></span></p>
                        <p><span style="font-size: 8pt;"><div id="chart_40" style="display:inline-block"></div></span></p>
                        <p><span style="font-size: 12pt;">Укажите год отчетности:</span></p>
                        <form action="andr/pointsExportBal.php" method="post">
                            <p><input max="2018" min="2016" name="year" type="number" value="2018" /></p>
                            <input name="company" type="hidden" value="baltika" /> <input type="submit" value="Экспорт в Excel" /></form>
                        <p> </p>
                        <p><span style="font-size: 10pt;"></span></p> 	</div>
                    </div>

                <!-- End Content -->
            </main>
</div>
