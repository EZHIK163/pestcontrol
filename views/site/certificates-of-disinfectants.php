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
                <h2 itemprop="name">Список используемых дез.средств </h2>
            </div>

            <div itemprop="articleBody">
                <p><strong>Ниже представлены сертификаты на дез. средства, перечисленные в </strong></p>
                <p><strong>Списке используемых дез. средств на 2018 г.</strong></p>
                <p>&nbsp;</p>
                <table style="border-color: #4a74af; width: 800px; margin-left: auto; margin-right: auto;" border="3">
                    <tbody>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%"><span style="font-size: 12pt;">&nbsp;"Абсолон"</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%"><a title="absolon_sertificat.pdf" href="/docs/absolon_sertificat.pdf" rel="alternate">&nbsp;</a><a href="/docs/absolon_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="absolut-gel_sertificat.pdf - 550 kb" border="0" height="60" width="60"> </a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%"><span style="font-size: 12pt;">&nbsp;"Абсолют-дуст"</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">&nbsp;<a href="/docs/absolut-dust_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="absolut-dust_sertificat.pdf - 550 kb" border="0" height="60" width="60"> </a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Абсолют-гель"</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/absolut-gel_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="absolut-gel_sertificat.pdf - 550 kb" border="0" height="60" width="60"> </a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Агран"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/agran.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="absolon_sertificat.pdf - 360 kb" border="0" height="60" width="60"> </a></td>
                    </tr>
                    <tr style="background-color: #ffffff; text-align: left;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Камикадзе" (Фумигация зернохранилищ) <br></span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/kamikadze.jpg" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="aktellik_sertificat.pdf - 1550 kb" border="0" height="60" width="60"> </a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Индан-блок"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a title="Document.png" href="/img/Document.png">&nbsp; <br> </a><a href="/docs/na_neskolko_sr-v_2_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="alfatrin,_muravei,_taraкan,_ciradon_sertificat.pdf - 2250 kb" border="0" height="60" width="60"> </a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF"><span style="font-size: 12pt;">&nbsp;Генератор"УМО Атомер"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF" width="10%"><a href="/docs/Atomep_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Atomep_instr" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF"><span style="font-size: 12pt;">&nbsp;Клей "АЛТ"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF" width="10%"><a href="/docs/alt_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="alt_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Арбалет"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/arbalet_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="arbalet_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Авицин"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/avicin_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="avicin_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Альфатрин-флоу"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/Alfatrin.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="na_neskolko_sr-v_(2)_sertificat.pdf" border="0" height="60" width="60"></a>&nbsp;</td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Биор"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/bior_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="bior_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF">
                            <p><span style="font-size: 12pt;">&nbsp;"Bird Gard-отпугиватель птиц"</span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF"><a href="/docs/Bird_Gard_declar.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Bird_Gard_declar.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF">
                            <p><span style="font-size: 12pt;">&nbsp; "Bird Gard-отпугиватель птиц"</span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF">&nbsp;<a href="/docs/Bird_Gard_FGUZ_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Bird_Gard_instr.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Аргус"</span><br style="font-size: 12pt;">
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/ArgusBlokbaster.jpg" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="gelcin_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Бромодиолон 0,25 %"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/bromodiolon_025__sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="bromodiolon_0,25_%_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF"><span style="font-size: 12pt;">&nbsp;"Аталант"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF"><a href="/docs/atlant.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="gelcin_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" bgcolor="#F5FFFF"><span style="font-size: 12pt;">&nbsp;"Инсектицид Вега"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" bgcolor="#F5FFFF"><a href="/docs/insekticid_vega_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="insekticid_vega_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Инсектицид Ципи"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/insekticid_cipi_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="insekticid_cipi_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;Инструкция по установке </span></p>
                            <p><span style="font-size: 12pt;">&nbsp;"ИНСЕКТ МОНИТОР"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/instrukciia_po_ustanovke_insekt_monitor_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="instrukciia_po_ustanovke_insekt_monitor_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Каракурт"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/karakurt_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="karakurt_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Каракурт липкая лента"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/karakurt_lipkaia_lenta_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="karakurt_lipkaia_lenta_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Раттидион"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/Rattid.jpg" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="konfidant_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Бродефор"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/brodefor.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="kotofei_kleevaia_lovushka_d_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Абсюлют-приманка"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/absolut_primanka.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="kleevaia_lovushka_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Клей mr.Mouse"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/klei_mr.Mouse_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="klei_mr.Mouse_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Контейнер Plastdiversity"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/Konteiner_Plastdiversity_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Konteiner_Plastdiversity_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Контейнер Plastdiversity"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/Konteiner_Plastdiversity_prilojenie.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="Konteiner_Plastdiversity_prilojenie.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Альфа 10"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/alfa10.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="krysit_gel_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Легион гель"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/legion_gel_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="legion_gel_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Тотал"</span></p>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/total.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="pregrada-kleevaia_lovushka_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Каракурт-супер"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a title="aktellik_sertificat.pdf" href="/docs/karakurt_super.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="na_neskolko_sr-v_(3)_domovoi_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Циперметрин 25"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/ciper25.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="fitar_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Цифокс"</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/cifoks_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="cifoks_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Абсолют 50"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/absolut50.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="flai_bait_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Штурм"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/shturm_sertificat.PDF" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="shturm_deklaraciia_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Фумифаст"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/fumifast_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="fumifast_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Фуфанон супер"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/FufSup.jpg" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="fufanon_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Эко Клей"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/eko_kley_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="eko_kley_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"КлейКун" феромонные ловушки</span><br>&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/KleyKun.JPG" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="cipertrin_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;"><span style="font-size: 12pt;">&nbsp;"Эффектив Ультра"</span>
                            <p style="text-align: right;">&nbsp;</p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/effektiv_ultra_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="effektiv_ultra_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Грызунит экстра"<br></span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;">&nbsp;<a href="/docs/GrizunEx.jpg" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="cipertrin_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    <tr style="background-color: #ffffff;">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Крысин" </span></p>
                            <p><span style="font-size: 12pt;">&nbsp;"Крысин-Блок" </span></p>
                            <p><span style="font-size: 12pt;">&nbsp;"Зоокумарин 1,5%&nbsp;&nbsp;&nbsp; </span></p>
                            <p><span style="font-size: 12pt;">&nbsp;"Зоокумарин нео"</span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/na_neskolko_sr-v_1_sertificat.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="na_neskolko_sr-v_(1)_sertificat.pdf" border="0" height="60" width="60"></a></td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;">
                            <p><span style="font-size: 12pt;">&nbsp;"Антитаракан-гель"</span></p>
                            <p><span style="font-size: 12pt;">&nbsp;"Цирадон"</span></p>
                        </td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;"><a href="/docs/Alfatrin.pdf" target="_blank" rel="alternate"><img src="/docs/PDFthumb.png" alt="na_neskolko_sr-v_(2)_sertificat.pdf" border="0" height="60" width="60"></a></td>
                    </tr>
                    </tbody>
                </table> 	</div>

        </div>


            <!-- End Content -->
    </main>
</div>
