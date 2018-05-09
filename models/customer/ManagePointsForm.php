<?php
namespace app\models\customer;

use yii\base\Model;

class ManagePointsForm extends Model {

    public $id_customer;

    public function rules()
    {
        return [
            [['id_customer',], 'required']
        ];
    }

}