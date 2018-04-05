<div id="spoiler1" class="spoilers">
    <?php
    use yii\helpers\Html;
    $schema = $model;
    ?>
    <div  class="title">
        <div class="scheme_title"><?php echo $schema['title']; ?></div>
    </div>
    <div class="desc">
        <div style="display: none" id="name_dropzone">inner-dropzone_<?= $schema['id_file_customer']?></div>
        <div style="display: none" id="id_file_customer"><?= $schema['id_file_customer']?></div>
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