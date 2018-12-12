<?php
namespace app\controllers;

use app\services\UserService;
use app\components\Widget;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerController extends Controller
{
    private $userService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        UserService $userService,
        array $config = []
    ) {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionUsers()
    {
        return $this->render('userList', $this->userService->getUsersForAdmin());
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
                        'actions'=> ['users'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
