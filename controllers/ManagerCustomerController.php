<?php
namespace app\controllers;

use app\components\Widget;
use app\forms\CustomerForm;
use app\services\UserService;
use app\tools\Tools;
use app\entities\UserRecord;
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
    private $userService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        UserService $userService,
        array $config = []
    ) {
        $this->userService = $userService;
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
        $model = new CustomerForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->customerService->addCustomer($model->name, $model->idOwner, $model->contacts);
            $this->redirect('customers');
        }

        $users = $this->userService->getUsersForDropDownList();
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

        $model = new CustomerForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->customerService->changeCustomer($model->id, $model->name, $model->idOwner, $model->contacts);
            $this->redirect('customers');
        }

        $customer = $this->customerService->getCustomer($id);
        $model->fetchCustomer($customer);
        $users = $this->userService->getUsersForDropDownList();

        return $this->render('edit-customer', compact('model', 'users'));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['*'],
                'rules' => [
                    [
                        'actions'=> ['customers', 'add-customer', 'delete-customer', 'edit-customer'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
