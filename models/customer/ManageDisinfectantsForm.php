<?php
namespace app\models\customer;

use app\entities\DisinfectantRecord;
use app\services\CustomerService;
use app\services\DisinfectantService;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ManageDisinfectantsForm
 * @package app\models\customer
 */
class ManageDisinfectantsForm extends Model
{
    public $disinfectants;

    private $customerService;

    private $disinfectantService;

    /**
     * ManageDisinfectantsForm constructor.
     * @param CustomerService $customerService
     * @param DisinfectantService $disinfectantService
     * @param array $config
     */
    public function __construct(CustomerService $customerService, DisinfectantService $disinfectantService, array $config = [])
    {
        $this->customerService = $customerService;
        $this->disinfectantService = $disinfectantService;
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
        $this->customerService->setDisinfectantsCustomer($id_customer, $this->disinfectants);
    }

    /**
     * @param $id_customer
     */
    public function fetchDisinfectants($id_customer)
    {
        $disinfectants_customer = $this->customerService->getDisinfectantsCustomer($id_customer);
        $disinfectants_customer = ArrayHelper::index($disinfectants_customer, 'id');

        $disinfectants = $this->disinfectantService->getDisinfectants();

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
