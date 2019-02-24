<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = "Управление схемами точек котроля {$name_customer}"; ?>
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
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <?php echo $form->field($model, 'query')
                    ->label('Введите название схемы точек контроля'); ?>

                <button>Поиск</button>

                <?php ActiveForm::end() ?>

            </div>

            <div itemprop="articleBody">
                <?php echo ListView::widget([
                    'dataProvider' => $data_provider,
                    'itemView' => 'scheme_customer',
                    'pager' => [
                        'class' => '\app\components\MyPagination',
                    ]
                ]); ?>

            </div>




            <!-- End Content -->
    </main>
</div>
