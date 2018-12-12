<?php
namespace app\controllers;

use app\tools\Tools;
use app\components\Widget;
use app\services\DisinfectorService;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class ManagerDisinfectorController
 * @package app\controllers
 */
class ManagerDisinfectorController extends Controller
{
    private $disinfectorService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param DisinfectorService $disinfectorService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        DisinfectorService $disinfectorService,
        array $config = []
    ) {
        $this->disinfectorService = $disinfectorService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionManageDisinfectors()
    {
        $disinfectors = $this->disinfectorService->getAllForManager();
        $data_provider = Tools::wrapIntoDataProvider($disinfectors);

        return $this->render('manage-disinfectors', compact('data_provider'));
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
                        'actions'=> ['manage-disinfectors'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ]
                ]
            ],
        ];
    }
}
