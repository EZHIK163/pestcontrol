<?php
namespace app\controllers;

use app\forms\DisinfectorForm;
use app\tools\Tools;
use app\components\Widget;
use app\services\DisinfectorService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Class ManagerDisinfectorController
 * @package app\controllers
 */
class ManagerDisinfectorController extends Controller
{
    /**
     * @var DisinfectorService
     */
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
     * @return string
     */
    public function actionEditDisinfector()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new DisinfectorForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->disinfectorService->saveDisinfector($model->fillDisinfector());
            $this->redirect('manage-disinfectors');
        }

        $disinfector = $this->disinfectorService->getDisinfector($id);
        $model->fillThis($disinfector);

        return $this->render('edit-disinfector', compact('model'));
    }

    /**
     *
     */
    public function actionDeleteDisinfector()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $this->disinfectorService->deleteDisinfector($id);

        $this->redirect('manage-disinfectors');
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
                        'actions'=> ['manage-disinfectors', 'edit-disinfector', 'delete-disinfector'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ]
                ]
            ],
        ];
    }
}
