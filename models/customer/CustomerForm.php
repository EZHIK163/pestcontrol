<?php
namespace app\models\customer;

use app\models\customer\Customer;
use app\models\user\UserRecord;
use yii\base\Model;

class CustomerForm extends Model {
    public $id;
    public $name;
    public $id_owner;
    public $contacts;

    public function rules()
    {
        return [
            [['id_owner', 'id'], 'number'],
            [['name', 'id_owner', 'contacts'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    public function fetchCustomer($id) {
        $customer = Customer::getCustomer($id);
        $this->name = $customer->name;
        $id_owner = isset($customer->id_user_owner) ? $customer->id_user_owner : null;
        $this->id_owner = $id_owner;
        $this->id = $customer->id;
        $this->contacts = CustomerContact::getContacts($id);

    }

    public function saveCustomer() {
        $customer = Customer::getCustomer($this->id);
        $customer->name = $this->name;

        Customer::setIdUserOwner($this->id, $this->id_owner);

        CustomerContact::updateContacts($this->contacts, $this->id);

        $customer->save();
    }

    public function addCustomer() {
        $customer = new Customer();
        $customer->name = $this->name;
        $customer->save();

        Customer::setIdUserOwner($customer->id, $this->id_owner);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Номер',
            'name' => 'Наименование',
            'id_owner' => 'Владелец',
            'contacts' => 'Контакты',
        ];
    }
}