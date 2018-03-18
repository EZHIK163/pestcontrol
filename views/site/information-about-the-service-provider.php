<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = "Управление рекомендациями"; ?>
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
                <h2 itemprop="name">Учредительные документы ООО "НПО "Лесное Озеро"</h2>
            </div>

            <div itemprop="articleBody">
                <div itemprop="articleBody">
                    <table style="height: 247px; margin-left: auto; margin-right: auto;" width="217">
                        <tbody>
                        <tr>
                            <td style="text-align: center;"><a href="docs/ustav.pdf" rel="alternate"><img src="/docs/ustav.jpg" alt="" height="214" width="150">&nbsp;</a></td>
                            <td style="text-align: center;"><a href="/docs/dogovor.pdf" rel="alternate"><img src="/docs/dogovor.jpg" alt="" height="214" width="150"></a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><a href="/docs/ustav.pdf" rel="alternate">Устав</a></td>
                            <td style="text-align: center;"><a href="/docs/dogovor.pdf" rel="alternate">Договор об учреждении</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="height: 45px; margin-left: auto; margin-right: auto;" width="170">
                        <tbody>
                        <tr>
                            <td style="text-align: center;"><a href="/docs/prikaz_gl_buh.pdf" rel="alternate"><img src="/docs/prikaz_gl_buh.jpg" alt="" height="214" width="150"></a></td>
                            <td style="text-align: center;"><a href="/docs/protokol1.pdf" rel="alternate"><img src="/docs/protokol1.jpg" alt="" height="214" width="150"></a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><a href="/docs/prikaz_gl_buh.pdf" rel="alternate">Приказ Глав бухгалтера</a></td>
                            <td style="text-align: center;"><a href="/docs/protokol1.pdf" rel="alternate">Протокол 1</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="height: 45px; margin-left: auto; margin-right: auto;" width="170">
                        <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <p><a href="/docs/svidetelstvo_inn.pdf" rel="alternate"><img src="/docs/svidetelstvo_inn.jpg" alt="" height="214" width="150"></a></p>
                            </td>
                            <td style="text-align: center;"><a href="/docs/svidetelstvo_ogrn.pdf" rel="alternate"><img src="/docs/svidetelstvo_ogrn.jpg" alt="" height="214" width="150"></a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Свидетельство ИНН</td>
                            <td style="text-align: center;">Свидетельство ОГРН</td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="height: 45px; margin-left: auto; margin-right: auto;" width="168">
                        <tbody>
                        <tr>
                            <td style="text-align: center;">
                                <p><a href="/docs/uvedomlenie_gosstatist.pdf" rel="alternate"><img src="/docs/uvedomlenie_gosstatist.jpg" alt="" height="214" width="150"></a></p>
                                <a href="/docs/uvedomlenie_gosstatist.pdf" rel="alternate">&nbsp;</a></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><a href="/docs/uvedomlenie_gosstatist.pdf" rel="alternate">Уведомление из статистики</a></td>
                        </tr>
                        </tbody>
                    </table> 	</div>

            </div>


            <!-- End Content -->
    </main>
</div>
