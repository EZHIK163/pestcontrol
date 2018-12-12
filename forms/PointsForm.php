<?php
namespace app\forms;

use yii\base\Model;

/**
 * Class PointsForm
 * @package app\forms
 */
class PointsForm extends Model
{
    public $idCustomer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idCustomer',], 'required']
        ];
    }
}
