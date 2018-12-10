<?php
namespace app\models\customer;

use app\services\CustomerService;
use yii\base\Model;

/**
 * Class CustomerForm
 * @package app\models\customer
 */
class CustomerForm extends Model
{
    public $id;
    public $name;
    public $id_owner;
    public $contacts;

    private $service;

    /**
     * CustomerForm constructor.
     * @param CustomerService $service
     * @param array $config
     */
    public function __construct(CustomerService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['id_owner', 'id'], 'number'],
            [['name', 'id_owner', 'contacts'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @param $id
     */
    public function fetchCustomer($id)
    {
        $data = $this->service->getInfoForCustomerForm($id);
        $this->id = $id;
        $this->name = $data['name'];
        $this->contacts = $data['contacts'];
        $this->id_owner = $data['id_owner'];
    }

    public function saveCustomer()
    {
        $this->service->changeCustomer($this->id, $this->name, $this->id_owner, $this->contacts);
    }

    public function addCustomer()
    {
        $this->service->addCustomer($this->name, $this->id_owner, $this->contacts);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'Номер',
            'name'      => 'Наименование',
            'id_owner'  => 'Владелец',
            'contacts'  => 'Контакты',
        ];
    }
}