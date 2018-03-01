<?php
$this->title = "Оценка рисков по точкам контроля"; ?>
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
                        <h2 itemprop="name">Оценка рисков по точкам контроля</h2>
                    </div>

                    <div itemprop="articleBody">
                        <table style="border-color: #127012; background-color: #127012;" border="1" cellspacing="1" cellpadding="5">
                            <tbody>
                            <tr>
                                <td><div id="chart_53" style="display:inline-block"></div></td>
                            </tr>
                            </tbody>
                        </table>
                        <p> </p>
                        <hr />
                        <p> </p>
                        <table style="border-color: #ab1515; background-color: #ab1515;" border="1" cellspacing="1" cellpadding="5">
                            <tbody>
                            <tr>
                                <td><div id="chart_54" style="display:inline-block"></div></td>
                            </tr>
                            </tbody>
                        </table>
                        <p> </p>
                    </div>
                    </div>

                <!-- End Content -->
            </main>
</div>
