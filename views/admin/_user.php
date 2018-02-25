<?php
echo yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes'    => [
        ['attribute'    => 'username'],
        ['attribute'    => 'password']
    ]
]);