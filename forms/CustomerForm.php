<?php
namespace app\forms;

use app\dto\Customer;
use yii\base\Model;

/**
 * Class CustomerForm
 * @package app\forms
 */
class CustomerForm extends Model
{
    public $id;
    public $name;
    public $idOwner;
    public $contacts;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idOwner', 'id'], 'number'],
            [['name', 'idOwner', 'contacts'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @param Customer $customer
     */
    public function fetchCustomer($customer)
    {
        $contacts = $customer->getContacts();
        foreach ($contacts as &$contact) {
            $contact = $contact->toArray();
        }

        $this->id = $customer->getId();
        $this->name = $customer->getName();
        $this->contacts = $contacts;
        $this->idOwner = $customer->getIdUserOwner();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'Номер',
            'name'      => 'Наименование',
            'idOwner'   => 'Владелец',
            'contacts'  => 'Контакты',
        ];
    }
}
