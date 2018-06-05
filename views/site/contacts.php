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
                <h2 itemprop="name">Контакты</h2>
            </div>

            <ul class="category list-striped">

                <li class="cat-list-row0">

						<span class="pull-right">
															Телефон: 8(846)951-94-53<br>


												</span>

                    <p>
                    </p><div class="list-title">
                        <a href="/kontakty/2-maksim-vladimirovich-nagaev">
                            Максим Владимирович Нагаев</a>
                    </div>
                    Начальник департамента<br>
                    Самара,

                    Россия<br>
                    <p></p>
                </li>

                <li class="cat-list-row1">

						<span class="pull-right">
															Телефон: 8(846)951-94-53<br>


												</span>

                    <p>
                    </p><div class="list-title">
                        <a href="/kontakty/6-kilyak">
                            -</a>
                    </div>
                    Техподдержка<br>
                    Самара,

                    Россия<br>
                    <p></p>
                </li>
            </ul>

        </div>


            <!-- End Content -->
    </main>
</div>
