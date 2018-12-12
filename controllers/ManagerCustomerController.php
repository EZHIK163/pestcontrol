<?php
namespace app\controllers;

use app\models\customer\CustomerForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\user\UserRecord;
use app\models\widget\Widget;
use app\services\CustomerService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerCustomerController extends Controller
{
    private $customerService;

    private $customerForm;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param CustomerForm $customerForm
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        CustomerForm $customerForm,
        array $config = []
    ) {
        $this->customerForm = $customerForm;
        $this->customerService = $customerService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

    /**
     * @return string
     */
    public function actionCustomers()
    {
        $users = $this->customerService->getCustomersForManager();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('customers', compact('data_provider'));
    }

    /**
     * @return string
     */
    public function actionAddCustomer()
    {
        $model = $this->customerForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->addCustomer();
            $this->redirect('customers');
        }

        $users = UserRecord::getUsersForDropDownList();
        return $this->render('add-customer', compact('model', 'users'));
    }

    /**
     *
     */
    public function actionDeleteCustomer()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $this->customerService->deleteCustomer($id);
            $this->redirect('customers');
        }
    }

    /**
     * @return string
     */
    public function actionEditCustomer()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = $this->customerForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveCustomer();
            $this->redirect('customers');
        }

        $model->fetchCustomer($id);
        $users = UserRecord::getUsersForDropDownList();
        return $this->render('edit-customer', compact('model', 'users'));
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
                'rules' => [
                    [
                        'actions'=> ['customers', 'add-customer',
                            'delete-customer', 'edit-customer'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
