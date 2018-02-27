<?php $this->title = "Главная"; ?>
<div class="row-fluid">
            <div id="sidebar" class="span3">
                <div class="sidebar-nav">
                    <?= \app\components\WellMenuWidget::widget(['data'  => $widget]) ?>
                    <?= \app\components\LoginWidget::widget(['model'    => $model]) ?>
                </div>
            </div>
            <main id="content" role="main" class="span9">
                <div id="system-message-container">
                </div>

                <div class="item-page" itemscope="" itemtype="http://schema.org/Article">
                    <meta itemprop="inLanguage" content="ru-RU">


                    <div class="page-header">
                        <h2 itemprop="name">Программа PestControl</h2>
                    </div>

                    <div class="icons">

                        <div class="btn-group pull-right">
                            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <span class="icon-cog"></span><span class="caret"></span> </a>
                            <ul class="dropdown-menu">
                                <li class="print-icon"> <a href="http://pestcontrol.lesnoe-ozero.com/?tmpl=component&amp;print=1&amp;page=" title="Печать" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;" rel="nofollow">Печать</a> </li>
                                <li class="email-icon"> <a href="http://pestcontrol.lesnoe-ozero.com/component/mailto/?tmpl=component&amp;template=protostar&amp;link=4b12cf2531e2194c34dcbb0228aba6089c787295" title="E-mail" onclick="window.open(this.href,'win2','width=400,height=350,menubar=yes,resizable=yes'); return false;" rel="nofollow">E-mail</a> </li>
                            </ul>
                        </div>

                    </div>

                    <div itemprop="articleBody">
                        <div align="">
                            <p align="justify"><span style="font-size: 12pt;"><b>Наша компания поможет Вам:</b></span></p>
                        </div>
                        <div align="">
                            <ul style="list-style-type: square;">
                                <li>В разработке и&nbsp;внедрении программы Пестконтроля на основе принципов ХАССП.</li>
                                <li>Обеспечить полную автоматизацию Пестконтроля на современном Европейском уровне!</li>
                                <li>В аудите существующей на предприятии системы Пестконтроля, выработке корректирующих рекомендаций.</li>
                                <li>Наши специалисты проведут тщательную оценку эффективности мероприятий по дезинсекции и&nbsp;дератизации, защите от птиц.</li>
                                <li>Проанализируют правильность составления и&nbsp;ведения документации
                                    по Пестконтролю, проконсультируют по всем вопросам, касающимся борьбы
                                    с&nbsp;вредителями и&nbsp;риска загрязнения (заражения) пищевой
                                    продукции.</li>
                                <li>В осуществлении регулярных процедур, предусмотренных программой Пестконтроля.</li>
                                <li>В оценке качества работ по программе Пестконтроля, проводимых третьей стороной.</li>
                                <li>В&nbsp;проведении масштабных истребительных мероприятий
                                    в&nbsp;случае значительного распространения грызунов, или
                                    насекомых-вредителей на предприятии.</li>
                            </ul>
                        </div>
                        <div align="">
                            <p align="justify"><b>При заключении договора с&nbsp;ГК "НПО "Лесное
                                    озеро" разработка программы Пестконтроля (программы по борьбе
                                    с&nbsp;вредителями) и&nbsp;электронное сопровождение с&nbsp;помощью
                                    "PestControl CRM" включены в&nbsp;договор.</b></p>
                            <p align="justify"><b>Заказать программу:</b></p>
                        </div>
                        <p><strong><img src="<?php echo Yii::$app->request->baseUrl; ?>/chart.png"></strong></p> 	</div>


                </div>

                <!-- End Content -->
            </main>
</div>
