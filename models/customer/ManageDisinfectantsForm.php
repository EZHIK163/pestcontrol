<?php
namespace app\models\customer;

use app\entities\DisinfectantRecord;
use app\services\CustomerService;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ManageDisinfectantsForm
 * @package app\models\customer
 */
class ManageDisinfectantsForm extends Model
{

    public $disinfectants;

    private $service;

    /**
     * ManageDisinfectantsForm constructor.
     * @param CustomerService $service
     * @param array $config
     */
    public function __construct(CustomerService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['disinfectants',], 'required']
        ];
    }

    /**
     * @param $id_customer
     */
    public function updateDisinfectants($id_customer)
    {
        $this->service->setDisinfectantsCustomer($id_customer, $this->disinfectants);
    }

    /**
     * @param $id_customer
     */
    public function fetchDisinfectants($id_customer)
    {
        $disinfectants_customer = $this->service->getDisinfectantsCustomer($id_customer);
        $disinfectants_customer = ArrayHelper::index($disinfectants_customer, 'id');

        $disinfectants = DisinfectantRecord::getDisinfectants();

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
