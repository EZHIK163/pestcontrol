<?php
use dosamigos\chartjs\ChartJs;
$this->title = "Отчет по дезсредствам"; ?>
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
                        <h2 itemprop="name">Отчет по дезсредствам</h2>
                    </div>

                    <div itemprop="articleBody">
                        <p><span style="font-family: impact,chicago; font-size: 14pt;"><span style="font-family: arial,helvetica,sans-serif;">Текущий месяц:</span></span></p>
                        <p><span style="font-family: arial,helvetica,sans-serif; font-size: 14pt;"><span style="font-size: 12pt;"><div id="chart_107" style="display:inline-block"></div></span></span><span style="font-family: impact,chicago; font-size: 12pt;"><span style="font-family: arial,helvetica,sans-serif;">      <br /></span></span></p>
                        <p> </p>
                        <hr />
                        <p> </p>
                        <p><span style="font-family: impact,chicago; font-size: 14pt;"><span style="font-family: arial,helvetica,sans-serif;">Предыдущий месяц:<br /></span></span></p>
                        <p><span style="font-family: impact,chicago; font-size: 14pt;"><span style="font-family: arial,helvetica,sans-serif;"><span style="font-family: arial,helvetica,sans-serif; font-size: 12pt;"><div id="chart_108" style="display:inline-block"></div></span></span></span><span style="font-family: arial,helvetica,sans-serif; font-size: 12pt;">           <br /></span></p>
                        <p> </p>
                        <p><span style="font-family: arial,helvetica,sans-serif; font-size: 14pt;">Укажите месяц и год отчетности:</span></p>
                        <form action="andr/poisonsExport.php" method="post">
                            <p><input max="12" min="1" name="month" type="number" value="1" /></p>
                            <p><input max="2018" min="2016" name="year" type="number" value="2018" /></p>
                            <p><input name="company" type="hidden" value="baltika" /></p>
                            <p><input type="submit" value="Экспорт в Excel" /></p>
                        </form> 	</div>
                    </div>
                </div>

                <!-- End Content -->
            </main>
</div>
