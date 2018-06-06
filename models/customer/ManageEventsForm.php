<?php
namespace app\models\customer;

use yii\base\Model;

class ManageEventsForm extends Model {

    public $id_customer;

    public function rules()
    {
        return [
            [['id_customer',], 'required']
        ];
    }

}