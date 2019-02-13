<?php
use yii\helpers\Html;

app\assets\ApplicationUiAssetBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta lang="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="Пест-контроль Самара, Pestcontrol, Лесное озеро, Lesnoe ozero">
    <meta name="description" content="Контроль обрабатываемых объектов">
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>

</head>
<body class="site com_content view-article no-layout no-task itemid-203">
<?php $this->beginBody() ?>
<div class="body">
    <div class="container">
        <header class="header" role="banner">
            <div class="header-inner clearfix">
                <a class="brand pull-left" href="http://pestcontrol.lesnoe-ozero.com/">
                    <span class="site-title" title="PestControl CRM™">PestControl CRM™</span>											</a>
                <div class="header-search pull-right">


                    <div class="custom">
                        <p><a href="http://www.lesnoe-ozero.com/" target="_blank" rel="tag">
                                <img src="<?= \Yii::$app->urlManager->createAbsoluteUrl(['/']) ?>logoSmall.png" alt=""></a></p></div>

                </div>
            </div>
            <?= \app\components\AuthWidget::widget() ?>
        </header>
        <?= \app\components\SliderWidget::widget() ?>
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
                    <?= $content; ?>
                </div>

                <!-- End Content -->
            </main>
        </div>
    </div>
</div>
<footer class="footer" role="contentinfo">
    <div class="container">
        <hr>
        <p class="pull-right">
            <a href="#top" id="back-top">Наверх</a>
        </p>
        <p>© 2019 PestControl CRM™</p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>