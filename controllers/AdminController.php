<?php
namespace app\controllers;

use app\services\UserService;
use app\tools\Tools;
use app\forms\UserForm;
use app\components\Widget;
use app\services\CustomerService;
use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class AdminController
 * @package app\controllers
 */
class AdminController extends Controller
{
    private $customerService;
    private $userService;

    /**
     * AdminController constructor.
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
        $this->customerService = $customerService;
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionUsers()
    {
        $users = $this->userService->getUsersForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('users', compact('data_provider'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionAddUser()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->userService->addUser($model->fillUser());
            $this->redirect('users');
        }

        $roles = $this->userService->getRolesForDropDownList();
        $customers = $this->customerService->getCustomerForDropDownList();

        return $this->render('add-user', compact('model', 'roles', 'customers'));
    }

    /**
     *
     */
    public function actionDeleteUser()
    {
        $id = Yii::$app->request->get('id');
        if (isset($id)) {
            $this->userService->deleteUser($id);
            $this->redirect('users');
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionEditUser()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->userService->saveUser($model->fillUser());
            $this->redirect('users');
        }

        $user = $this->userService->getUser($id);
        $model->fetchUser($user);

        $roles = $this->userService->getRolesForDropDownList();
        $customers = $this->customerService->getCustomerForDropDownList();

        return $this->render('edit-user', compact('model', 'roles', 'customers'));
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
                        'controllers'   => ['admin'],
                        'roles'     => ['admin'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}
