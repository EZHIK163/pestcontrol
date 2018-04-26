<?php
namespace app\models\tools;

use yii\data\ArrayDataProvider;

class Tools {
    public static function wrapIntoDataProvider($data, $is_need_pagination = true) {
        $data = [
            'allModels'     => $data,

        ];
        if ($is_need_pagination) {
            $data = array_merge($data, ['pagination' => [
                'pageSize' => 10,
            ],]);
        } else {
            $data = array_merge($data, ['pagination' => false]);
        }
        return new ArrayDataProvider($data);
    }
}

