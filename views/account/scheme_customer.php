<div id="spoiler1" class="spoilers">
    <?php
    use yii\helpers\Html;

$schema = $model;
    $base_url = \Yii::$app->urlManager->createAbsoluteUrl(['/']);
    ?>
    <div  class="title">
        <div class="scheme_title"><?php echo $schema['title']; ?></div>

    </div>
    <div class="desc">
        <div class="scheme_manage">
            <?=Html::tag(
                'a',
                'Выгрузить отчет',
                [
                    'href'  => $base_url.'account/generate-report-schema-point-control?id='.$schema['id_file_customer'],
                    'target'    => '_blank',
                ]
            )?>
            |
            <?=Html::tag(
                'a',
                'Печать',
                [
                    //'href'  => $base_url.'account/print-schema-point-control?id='.$scheme['id_file_customer'],
                    //'target'    => '_blank',
                    'onclick'    => "CallPrint('print-content_{$schema['id_file_customer']}');"
                    //'onclick'    => "CallPrint('outer-dropzone2');"
                ]
            )?>
        </div>
        <div style="display: none" id="name_dropzone">inner-dropzone_<?= $schema['id_file_customer']?></div>
        <div style="display: none" id="id_file_customer"><?= $schema['id_file_customer']?></div>
        <div id="print-content_<?=$schema['id_file_customer']?>" >
        <div id="outer-dropzone2" class="dropzone">
            <div id="inner-dropzone_<?=$schema['id_file_customer']?>" class="dropzone">
                <?= Html::img($schema['url'], [
                    'alt' => $schema['title'],
                    //'onclick'    => 'showPoints("inner-dropzone_'.$scheme['id_file_customer'].'", '.$scheme['id_file_customer'].');'
                ]) ?>
            </div>
        </div>
        </div>

</div>