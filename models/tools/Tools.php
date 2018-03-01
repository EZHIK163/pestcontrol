<?php
namespace app\models\tools;

use yii\data\ArrayDataProvider;

class Tools {
    public static function wrapIntoDataProvider($data) {
        return new ArrayDataProvider([
            'allModels'     => $data,
            'pagination'    => false
        ]);
    }
}

