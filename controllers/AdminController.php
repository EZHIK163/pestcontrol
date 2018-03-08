<?php
namespace app\controllers;

use app\models\customer\Customer;
use app\models\tools\Tools;
use app\models\user\Role;
use app\models\user\UserForm;
use app\models\user\UserRecord;
use app\models\widget\Widget;
use yii\base\InvalidArgumentException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\User;

class AdminController extends Controller {

    public function actionUsers() {
        $users = UserRecord::getUsersForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('users', compact('data_provider'));
    }

    public function actionAddUser() {

        $model = new UserForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->addUser();
            $this->redirect('users');
        }

        $roles = Role::getRolesForDropDownList();
        $customers = Customer::getCustomerForDropDownList();
        return $this->render('add-user', compact('model', 'roles', 'customers'));
    }

    public function actionDeleteUser() {
        $id = \Yii::$app->request->get('id');
        if (isset($id)) {
            UserRecord::deleteUser($id);
            $this->redirect('users');
        }
    }

    public function actionEditUser() {
        $id = \Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new UserForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->saveUser();
            $this->redirect('users');
        }

        $model->fetchUser($id);
        $roles = Role::getRolesForDropDownList();
        $customers = Customer::getCustomerForDropDownList();
        return $this->render('edit-user', compact('model', 'roles', 'customers'));
    }


    public function render($view, $params = [])
    {
        $params = array_merge($params, Widget::getWidgetsForAccount());
        return parent::render($view, $params);
    }

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