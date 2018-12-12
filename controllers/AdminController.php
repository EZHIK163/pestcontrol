<?php
namespace app\controllers;

use app\models\tools\Tools;
use app\models\user\Role;
use app\models\user\UserForm;
use app\models\user\UserRecord;
use app\models\widget\Widget;
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

    private $userForm;

    /**
     * AdminController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param UserForm $userForm
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        UserForm $userForm,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->userForm = $userForm;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionUsers()
    {
        $users = UserRecord::getUsersForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('users', compact('data_provider'));
    }

    /**
     * @return string
     */
    public function actionAddUser()
    {
        $model = $this->userForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->addUser();
            $this->redirect('users');
        }

        $roles = Role::getRolesForDropDownList();
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
            UserRecord::deleteUser($id);
            $this->redirect('users');
        }
    }

    /**
     * @return string
     */
    public function actionEditUser()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = $this->userForm;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveUser();
            $this->redirect('users');
        }

        $model->fetchUser($id);
        $roles = Role::getRolesForDropDownList();
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
