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
                <h5><span style="font-size: 12pt;">Список используемых дез.средств вы можете скачать ниже по ссылке:</span></h5>
                <p><a title="Список используемых дез.средств 2017" href="/docs/spisok2018.xls" rel="alternate">Список используемых дез.средств 2018 (Excel)</a></p>
                <p><a title="Список используемых дез.средств 2016" href="/docs/spisok2018.PDF" target="_blank" rel="alternate">Список используемых дез.средств 2018 (Pdf заверенный печатью)</a></p>
                <p>&nbsp;</p> 	</div>

        </div>


            <!-- End Content -->
    </main>
</div>
