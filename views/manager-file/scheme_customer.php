<div id="spoiler1" class="spoilers">
    <?php
    use yii\helpers\Html;

    $base_url = \Yii::$app->urlManager->createAbsoluteUrl(['/']);
    $title = 'Удаление доступно только для схем без точек. Отключите все точки перед удалением';
    ?>
    <div class="general_title"><?php echo $model[0]['customer']; ?> </div>
    <div class="desc">
    <?php $count = 0; foreach ($model as $scheme) {
        if ($scheme['is_available_delete'] === true) {
            $uriDelete = 'delete-schema-point-control?id='.$scheme['id_file_customer'];
            $tag = 'a';
        } else {
            $tag = 'abbr';
            $uriDelete = '';
        }
        ?>
        <div  class="title <?php if ($count == 0) {
            ?> active <?php
        } ?>">
            <div class="scheme_title"><?php echo $scheme['title']; ?></div>

        </div>
        <div class="desc">

            <div class="scheme_manage">
                <?=Html::tag(
        'a',
        'Изменить',
                    ['href'  => 'edit-schema-point-control?id='.$scheme['id_file_customer']]
    )?>
                |
                <?=Html::tag(
                    'a',
                    'Переименовать',
                    [
                        'href'  => 'edit-title-schema-point-control?id='.$scheme['id_file_customer']
                    ]
                )?>
                |
                <?=Html::tag(
                        $tag,
                        'Отключить',
                    [
                            'href'  => $uriDelete,
                            'title' => $title
                    ]
                    )?>
                |
                <?=Html::tag(
                        'a',
                        'Выгрузить отчет',
                    [
                        //'href'  => $base_url.'account/generate-report-schema-point-control?id='.$scheme['id_file_customer'],
                        'target'    => '_blank',
                        'data-pjax'=>"0"
                    ]
                    )?>
                |
                <?=Html::tag(
                        'a',
                        'Печать',
                    [
                        //'href'  => $base_url.'account/print-schema-point-control?id='.$scheme['id_file_customer'],
                        //'target'    => '_blank',
                        'onclick'    => "CallPrint('print-content_{$scheme['id_file_customer']}');"
                        //'onclick'    => "CallPrint('outer-dropzone2');"
                    ]
                    )?>
            </div>

            <div style="display: none" id="name_dropzone">inner-dropzone_<?= $scheme['id_file_customer']?></div>
            <div style="display: none" id="id_file_customer"><?= $scheme['id_file_customer']?></div>

            <div id="print-content_<?=$scheme['id_file_customer']?>" >
            <div id="outer-dropzone2" class="dropzone">
                <div id="inner-dropzone_<?=$scheme['id_file_customer']?>" class="dropzone">
                    <?= Html::img($scheme['url'], [
                        'alt' => $scheme['title'],
                        //'onclick'    => 'showPoints("inner-dropzone_'.$scheme['id_file_customer'].'", '.$scheme['id_file_customer'].');'
                    ]) ?>
                </div>
            </div>
            </div>

        </div>
    <?php $count++;
    } ?>
    </div>
</div>