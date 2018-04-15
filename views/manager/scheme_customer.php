<div id="spoiler1" class="spoilers">
    <?php
    use yii\helpers\Html;

    $base_url = \Yii::$app->urlManager->createAbsoluteUrl(['/']);
    ?>
    <div class="general_title"><?php echo $model[0]['customer']; ?> </div>
    <div class="desc">
    <?php $count = 0; foreach ($model as $scheme) { ?>
        <div  class="title <?php if ($count == 0) { ?> active <?php } ?>">
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
                |
                <?=Html::tag('a', 'Выгрузить отчет',
                    [
                        'href'  => $base_url.'account/generate-report-schema-point-control?id='.$scheme['id_file_customer'],
                        'target'    => '_blank',
                        'data-pjax'=>"0"
                    ])?>
            </div>
        </div>
        <div class="desc">
            <div style="display: none" id="name_dropzone">inner-dropzone_<?= $scheme['id_file_customer']?></div>
            <div style="display: none" id="id_file_customer"><?= $scheme['id_file_customer']?></div>
            <div id="inner-dropzone_<?=$scheme['id_file_customer']?>" class="my_name">
                <?= Html::img($scheme['url'], [
                    'alt' => $scheme['title'],
                    //'onclick'    => 'showPoints("inner-dropzone_'.$scheme['id_file_customer'].'", '.$scheme['id_file_customer'].');'
                ]) ?>
            </div>

        </div>
    <?php $count++; } ?>
    </div>
</div>