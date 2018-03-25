<div id="spoiler1" class="spoilers">
    <?php use yii\helpers\Html; ?>
    <div class="title"><?php echo $model[0]['customer']; ?> </div>
    <div class="desc">
    <?php foreach ($model as $scheme) { ?>
        <div class="title"><?php echo $scheme['title']; ?> </div>
        <div class="desc">
            <?= Html::img($scheme['url'], ['alt' => $scheme['title']]) ?>
        </div>
    <?php } ?>
    </div>
</div>