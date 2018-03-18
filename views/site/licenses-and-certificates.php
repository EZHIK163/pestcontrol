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
                <h2 itemprop="name">Лицензии, сертификаты, СРО, ИСО</h2>
            </div>

            <div itemprop="articleBody">
                <table style="height: 490px;" width="495">
                    <tbody>
                    <tr>
                        <td style="text-align: center; vertical-align: middle;">
                            <p><a href="/docs/Expert_verdikt.PDF" target="_blank" rel="alternate"><strong><img src="/docs/Expert_verdikt.jpg" alt="Экспертное заключение" width="150"></strong></a></p>
                        </td>
                        <td style="text-align: center;"><a href="/docs/License_medic_work.jpg" target="_blank" rel="alternate"><img src="/docs/License_medic_work.jpg" alt="Лицензия на мед деятельность с 2015" height="213" width="150"></a></td>
                        <td style="text-align: center;"><a href="/docs/San_Epid_Zakl0001.pdf" target="_blank" rel="alternate"><img src="/docs/San_Epid_Zakl0001.jpg" alt="Санитарно- эпидемиологическое заключение  Сертификат ИСО" height="213" width="150"></a></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><a title="Экспертное_заключение" href="/docs/Expert_verdikt.PDF" rel="alternate">Экспертное заключение</a></td>
                        <td style="text-align: center;">
                            <p><a title="Лицензия на мед деятельность с 2015г." href="/docs/License_medic_work.PDF" rel="alternate">Лицензия на мед деятельность с 2015г.</a></p>
                        </td>
                        <td style="text-align: center;"><a title="Санитарно- эпидемиологическое заключение" href="/docs/San_Epid_Zakl0001.pdf" rel="alternate">Санитарно- эпидемиологическое заключение</a></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><a href="/docs/Sertifikate_ISO9001.pdf" target="_blank" rel="alternate"><strong><img src="/docs/Sertifikate_ISO9001.jpg" alt="Сертификат ИСО" width="150"></strong></a></td>
                        <td style="text-align: center;"><a href="/docs/Sertifikate_SRO.pdf" target="_blank" rel="alternate"><strong><img src="/docs/Sertifikate_SRO.jpg" alt="Сертификат СРО" width="150"></strong></a></td>
                        <td style="text-align: center;"><a href="/docs/SEZ_Entomology.pdf" target="_blank" rel="alternate"><strong><img src="/docs/SEZ_Entomology.jpg" alt="СЭЗ Энтомология" width="150"></strong></a></td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><a href="/docs/Sertifikate_ISO9001.pdf" rel="alternate">Сертификат ИСО</a></td>
                        <td style="text-align: center;"><a href="/docs/Sertifikate_SRO.pdf" rel="alternate">Сертификат СРО</a></td>
                        <td style="text-align: center;"><a href="/docs/SEZ_Entomology.pdf" rel="alternate">СЭЗ Энтомология</a></td>
                    </tr>
                    </tbody>
                </table>
                <p><strong>&nbsp;</strong></p>
                <p>&nbsp;</p> 	</div>

        </div>


            <!-- End Content -->
    </main>
</div>
