<div class="block">
    <?php use yii\helpers\Html; ?>
    <div class="extremum-click"><?php echo $model[0]['customer']; ?> </div>
    <div class="extremum-slide">
    <?php foreach ($model as $scheme) { ?>
        <div class="extremum-click"><?php echo $scheme['title']; ?> </div>
        <div class="extremum-slide">
            <?= Html::img($scheme['url'], ['alt' => $scheme['title']]) ?>
        </div>
    <?php } ?>
    </div>
</div>