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
                <p><strong>Списке используемых дез. средств на 2019 г.</strong></p>
                <p>&nbsp;</p>
                <table style="border-color: #4a74af; width: 800px; margin-left: auto; margin-right: auto;" border="3">
                    <tbody>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолон-гель</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolon-gel_sertificat.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолон</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolon_sertificat.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют 50</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolut50.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют-дуст</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolut-dust_sertificat.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют-гель</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/absolut-gel_sertificat.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют-мелок/Претикс супер антиклещ</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolut-melok.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют-приманка</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">

                            <a href="/docs/certificates/absolut-primanka.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Абсолют тотал</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/absolut-total.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Агран</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/agran.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Альфа 10</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/alfa-10.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">АЛТ (клей)</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/alt-klej.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Арбалет</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/arbalet.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Mr. Mouse, ARGUS, Тайга, Блокбастер, Машенька, Камикадзе, Котофей, Штурм</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/argus-blokbaster-mashenka.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                            <a href="/docs/certificates/argus-blokbaster-mashenka-2.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                            <a href="/docs/certificates/argus-blokbaster-mashenka-3.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                            <a href="/docs/certificates/argus-blokbaster-mashenka-4.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Атлант</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/atlant.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Авицин</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/avicin.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">БИОР-1</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/bior_sertificat.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Бомбей</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/bombej1.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                            <a href="/docs/certificates/bombej2.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Бродефор</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/brodefor.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Бромадиолон-0.25</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/bromadiolon.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Циперметрин25</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/cipermetrin25-1.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                            <a href="/docs/certificates/cipermetrin25-2.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                            <a href="/docs/certificates/cipermtrin25-3.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Ципи</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/cipi.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Дельта 25</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/delta.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Домовой-мелок, Тройной удар, Прочь моль-спрей, Домовой-антимоль, Домовой Прошка - гель, Домовой Прошка - Ловушки от тараканов и муравьев</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/domovoj-melok.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Эко-абсолют порошок</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/eko-absolut-poroshok.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Этилфенацин-паста-2, гельдан, крысид-гель, крысид-приманка, зерноцин-у, бромоцид, зерноцин-блок,индан-блок, индан-флюид, индан-дуст, бродифан, гельцин, зоокумарин 1.5% порошок, крысин, зоокумарин нео, крысин-блок</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/etilfinacin-pasta.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                            <a href="/docs/certificates/etilfinacin-pasta-2.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Клей-кун, Апимаг, Аписил</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/ferromony.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Форс-сайт клеевая ловушка</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/fors-saite.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Гранд</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/grand.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                            <a href="/docs/certificates/grand2.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Каракурт</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/karakurt-granuly.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Каракурт супер-приманка от мух декоративная</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/karrkur-supper.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                            <a href="/docs/certificates/karrkur-supper2.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Каракурт липкая лента</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/kll.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Крысид-приманка, зерноцин-у, зерноцин-блок, индан-блок, крысин, зерноцин нео, зоокумарин нео, крысин-блок, блокада-клей</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/krysid-primanka.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Легион-гель</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/legion-gel.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Альфатрин-флоу, максифос, антитаракан-гель, антимуравей, миттокс-антимоль, циралон 11% в.к.э.</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/alfatrin-flou.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Раттидион</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/rattidion.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Пиретрум, агро-пирет-1</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/piretrum-agropivet.jpg" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Штурм</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/shturm.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Тотал</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            <a href="/docs/certificates/total.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60"> </a>
                        </td>
                    </tr>
                    <tr style="background-color: #ffffff;" bgcolor="#F5FFFF">
                        <td style="background-color: #ffffff; width: 40%; text-align: left; vertical-align: middle;" width="40%">
                            <span style="font-size: 12pt;">Инсектицид Вега</span></td>
                        <td style="background-color: #ffffff; text-align: center; vertical-align: middle;" width="10%">
                            
                            <a href="/docs/certificates/vega.pdf" target="_blank" rel="alternate">
                                <img src="/docs/PDFthumb.png" alt="alt" border="0" height="60" width="60">
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


            <!-- End Content -->
    </main>
</div>
