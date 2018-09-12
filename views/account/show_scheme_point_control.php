<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = "Статистика по схеме точек котроля: {$model['title']}"; ?>
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
                <h2 itemprop="name"><?= $this->title ?></h2>
            </div>

            <div itemprop="articleBody">
                <div class="desc">
                    <div style="display: none" id="name_dropzone">inner-dropzone_<?= $model['id_file_customer']?></div>
                    <div style="display: none" id="id_file_customer"><?= $model['id_file_customer']?></div>
                    <div id="outer-dropzone2" class="dropzone">
                        <div id="inner-dropzone_<?=$model['id_file_customer']?>" class="dropzone">
                            <?= Html::img($model['url'], [
                                'alt' => $model['title'],
                                'onload'    => 'showPoints("inner-dropzone_'.$model['id_file_customer'].'", '.$model['id_file_customer'].');'
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>

            </div>



            <!-- End Content -->
    </main>
</div>
