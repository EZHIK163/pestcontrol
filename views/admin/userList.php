<?php
echo yii\widgets\ListView::widget([
    'options'       => [
        'class'     => 'list-view',
        'id'        => 'search_results'
    ],
    'itemView'      => '_user',
    'dataProvider'  => $records,
    'emptyText' => 'Пользователи сайта не найдены',
    'summary' => 'Всего {totalCount} пользователей'
]);