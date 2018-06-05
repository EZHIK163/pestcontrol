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
                <h2 itemprop="name">Документы на сотрудников</h2>
            </div>

            <div itemprop="articleBody">
                <table style="height: 111px; border-color: #4a74af;" border="3" cellspacing="1" cellpadding="1" width="100%">
                    <tbody>
                    <tr>
                        <td width="40%"><strong>Руководители</strong></td>
                        <td width="10%">&nbsp;скачать</td>
                        <td width="40%"><strong>Дезинфектолог</strong></td>
                        <td width="10%">&nbsp;&nbsp;скачать</td>
                    </tr>
                    <tr>
                        <td>Нагаев М.В. Диплом участия</td>
                        <td><a title="Nagaev_Diplom.pdf" href="/docs/Nagaev_Diplom.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="absolon_sertificat.pdf - 360 kb" height="60" width="59"> </a></td>
                        <td>Сертификат Дезинфектолога</td>
                        <td><a title="sertificate_desinfectolog.pdf " href="/docs/sertificate_desinfectolog.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="sertificate_desinfectolog.pdf - 680 кб " height="60" width="59"> </a></td>
                    </tr>
                    <tr>
                        <td>Нагаев М.В. Удостоверение "Институт пест-менеджмента"</td>
                        <td><a title="Nagaev_Udostover.pdf" href="/docs/Nagaev_Udostover.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Nagaev_Udostover.pdf - 1.58 MB " height="60" width="59"> </a></td>
                        <td>&nbsp;Удостоверение Дезинфектолога</td>
                        <td><a title="absolon_sertificat.pdf" href="/docs/absolon_sertificat.pdf" rel="alternate">&nbsp;</a><a title="Udostoverenia.pdf " href="/docs/Udostoverenia.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Udostoverenia.pdf  - 1.15 MB " height="60" width="59"> </a></td>
                    </tr>
                    <tr>
                        <td>Яровой О.Г. Диплом участия</td>
                        <td><a title="Yarovoy_Diplom.pdf" href="/docs/Yarovoy_Diplom.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Yarovoy_Diplom.pdf - 1.54 MB " height="60" width="59"> </a><a title="Nagaev_Udostover.pdf" href="/docs/Nagaev_Udostover.pdf" rel="alternate">&nbsp;</a></td>
                        <td>&nbsp;Удостоверение Эпидемолога</td>
                        <td><a title="absolon_sertificat.pdf" href="/docs/absolon_sertificat.pdf" rel="alternate">&nbsp;</a><a title="Udostoverenie_Arshina_G.V.pdf" href="/docs/Udostoverenie_Arshina_G.V.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Udostoverenie_Arshina_G.V..pdf - 1.58 MB " height="60" width="59"> </a></td>
                    </tr>
                    <tr>
                        <td>Яровой О.Г. Удостоверение "Институт пест-менеджмента"</td>
                        <td><a title="Яровой. Удостоверение" href="/docs/Yarovoy_Udostover.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Yarovoy_Udostover.pdf  - 1.66 MB" height="60" width="59"> </a></td>
                        <td>&nbsp;</td>
                        <td><a title="Diplom.PDF" href="/docs/Diplom.PDF" target="_blank" rel="alternate">&nbsp; </a></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Нагаев М.В. Эксперт-аудитор ISO 9001-2011</p>
                        </td>
                        <td><a title="Нагаев М.В. Эксперт-аудитор, 0.411Мб" href="/docs/Nagaev_expert_auditor.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Nagaev_expert_auditor.pdf  - 0.41 MB" height="60" width="59"> </a></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    </tbody>
                </table>
                <p>&nbsp;</p>
                <table style="height: 111px; border-color: #4a74af;" border="3" cellspacing="1" cellpadding="1" width="100%">
                    <tbody>
                    <tr>
                        <td width="40%"><strong>Сотрудники</strong></td>
                        <td width="10%">&nbsp;скачать</td>
                        <td width="40%"><strong>Энтомолог</strong></td>
                        <td width="10%">&nbsp;&nbsp;скачать</td>
                    </tr>
                    <tr>
                        <td>Удостоверения Инструктор-Дезинфекторов</td>
                        <td><a title="Udostoverenia_Dez.delo.PDF" href="/docs/Udostoverenia_Dez.delo.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Udostoverenia_Dez.delo.PDF 4,5мб" height="60" width="59"> </a></td>
                        <td>Удостоверения Энтомолога</td>
                        <td><a title="Etnomolog.pdf" href="/docs/Etnomolog.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Etnomolog.pdf - 3.04 MB" height="60" width="59">&nbsp;</a><a title="Etnomolog_Nacharova.pdf" href="/docs/Etnomolog_Nacharova.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Etnomolog_Nacharova.pdf - 1.04 MB" height="60" width="59"> </a></td>
                    </tr>
                    </tbody>
                </table>
                <p>&nbsp;</p> 	</div>

        </div>


            <!-- End Content -->
    </main>
</div>
