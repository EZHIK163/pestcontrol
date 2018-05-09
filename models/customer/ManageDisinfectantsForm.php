<?php
namespace app\models\customer;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class ManageDisinfectantsForm extends Model {

    public $disinfectants;

    public function rules()
    {
        return [
            [['disinfectants',], 'required']
        ];
    }

    public function updateDisinfectants($id_customer) {
        Customer::setDisinfectantsCustomer($id_customer, $this->disinfectants);
    }

    public function fetchDisinfectants($id_customer) {

        $disinfectants_customer = Customer::getDisinfectantsCustomer($id_customer);
        $disinfectants_customer = ArrayHelper::index($disinfectants_customer, 'id');

        $disinfectants = Disinfectant::getDisinfectants();

        foreach ($disinfectants as &$disinfectant) {

            $is_set = isset($disinfectants_customer[$disinfectant['id']]);
            $disinfectant['disinfectant'] = $disinfectant['description'];
            $disinfectant['is_set'] = $is_set;
            unset($disinfectant['description']);
            unset($disinfectant['value']);
        }

        $this->disinfectants = $disinfectants;
    }
}