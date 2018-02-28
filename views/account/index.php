<?php
$this->title = "Личный кабинет"; ?>
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
                        <h2 itemprop="name">Личный кабинет</h2>
                    </div>

                    <div itemprop="articleBody">
                        <p><span style="font-size: 12pt; color: #000000;">        Программное обеспечение <strong>PestControl</strong> <strong>CRM</strong>, предназначено для автоматизации процесса пестконтроля. Вы легко, в режиме онлайн можете наблюдать и контролировать весь процесс проведения работ на Вашем предприятии. </span></p>
                        <p><span style="font-size: 12pt; color: #000000;"><span style="background-color: #ffffff;">Посмотреть результаты последнего мониторинга</span>, или за выбранный Вами период. </span></p>
                        <p><span style="font-size: 12pt; color: #000000;">Посмотреть отчет по точкам контроля, или <span style="background-color: #ffffff;">отчет по всему предприятию</span> за выбранный период времени.</span></p>
                        <p><span style="font-size: 12pt; color: #000000;">Посмотреть результаты на графике, или сформировать отчет «Оценка заселенности объекта», на котором Вы увидите заселенность Вашего объекта и оцените эффективность проводимых работ по борьбе с вредителями.</span></p>
                        <p><span style="font-size: 12pt; color: #000000;"> </span></p>
                        <p><span style="font-size: 12pt; color: #000000;"><strong>Мы рады сотрудничеству с Вами и ценим Ваше время и труд!</strong></span></p> 	</div>

                </div>

                <!-- End Content -->
            </main>
</div>
