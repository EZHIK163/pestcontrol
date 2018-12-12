<?php
namespace app\forms;

use yii\base\Model;

/**
 * Class EventsForm
 * @package app\forms
 */
class EventsForm extends Model
{
    /**
     * @var int
     */
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
