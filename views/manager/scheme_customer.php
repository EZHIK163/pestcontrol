<div id="spoiler1" class="spoilers">
    <?php use yii\helpers\Html; ?>
    <div class="title active"><?php echo $model[0]['customer']; ?> </div>
    <div class="desc">
    <?php $count = 0; foreach ($model as $scheme) { ?>
        <div class="title <?php if ($count == 0) { ?> active <?php } ?>">
            <div class="scheme_title"><?php echo $scheme['title']; ?></div>
            <div class="scheme_manage">
                <?=Html::tag('a', 'Изменить',
                    ['href'  => 'edit-schema-point-control?id='.$scheme['id_file_customer']])?>
                |
                <?=Html::tag('a', 'Удалить',
                    ['href'  => 'delete-schema-point-control?id='.$scheme['id_file_customer']])?>
                |
                <?=Html::tag('a', 'Скачать',
                    [
                        'href'      => $scheme['url'],
                        'target'    => '_blank',
                        'data-pjax'=>"0"
                    ])?>
            </div>
        </div>
        <div class="desc">
            <?= Html::img($scheme['url'], ['alt' => $scheme['title']]) ?>
        </div>
    <?php $count++; } ?>
    </div>
</div>