<?php
namespace app\forms;

use yii\base\Model;

/**
 * Class SearchSchemeForm
 * @package app\forms
 */
class SearchSchemeForm extends Model
{
    /**
     * @var string
     */
    public $query;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['query'], 'safe']
        ];
    }
}
