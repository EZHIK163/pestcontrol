<?php
namespace app\tools;

use yii\data\ArrayDataProvider;

/**
 * Class Tools
 * @package app\tools
 */
class Tools
{
    /**
     * @param $data
     * @param bool $is_need_pagination
     * @param array $sort_column
     * @return ArrayDataProvider
     */
    public static function wrapIntoDataProvider($data, $is_need_pagination = true, $sort_column = [])
    {
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
        if (is_array($sort_column) && count($sort_column) > 0) {
            $sort = [
                'sort' => ['attributes' => $sort_column],
            ];
            $data = array_merge($data, $sort);
        }

        return new ArrayDataProvider($data);
    }
}
