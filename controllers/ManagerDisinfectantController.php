<?php
namespace app\controllers;

use app\components\Widget;
use app\forms\DisinfectantForm;
use app\forms\DisinfectantsForm;
use app\tools\Tools;
use app\services\CustomerService;
use app\services\DisinfectantService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerDisinfectantController extends Controller
{
    private $customerService;
    private $disinfectantService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param DisinfectantService $disinfectantService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        DisinfectantService $disinfectantService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->disinfectantService = $disinfectantService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionManageDisinfectants()
    {
        $disinfectants = $this->disinfectantService->getDisinfectants();
        $data_provider = Tools::wrapIntoDataProvider($disinfectants);
        return $this->render('disinfectants', compact('data_provider'));
    }

    /**
     * @return string
     */
    public function actionManageDisinfectantsOnCustomers()
    {
        $users = $this->customerService->getCustomersWithDisinfectants();
        $data_provider = Tools::wrapIntoDataProvider($users);
        return $this->render('manage-disinfectants-on-customers', compact('data_provider'));
    }

    /**
     * @return string
     */
    public function actionManageCustomerDisinfectant()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new DisinfectantsForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->customerService->setDisinfectantsCustomer($id, $model->fillDisinfectants());
            $this->redirect('manage-disinfectants-on-customers');
        }

        $disinfectantsCustomer = $this->customerService->getDisinfectantsCustomer($id);

        $disinfectantsAll = $this->disinfectantService->getDisinfectants();

        $model->fetchDisinfectants($disinfectantsCustomer, $disinfectantsAll);

        return $this->render('manage-customer-disinfectant', compact('model'));
    }

    /**
     * @return string
     */
    public function actionEditDisinfectant()
    {
        $id = Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new DisinfectantForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->disinfectantService->saveDisinfectant($model->fillDisinfectant()->setId($id));
        }

        $disinfectant = $this->disinfectantService->getDisinfectant($id);
        $model->fillThis($disinfectant);

        return $this->render('manage-disinfectant', compact('model'));
    }

    /**
     * @return Response
     */
    public function actionDeleteDisinfectant()
    {
        $id = Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $this->disinfectantService->deleteDisinfectant($id);

        return $this->redirect('manage-disinfectants');
    }

    /**
     * @return string
     */
    public function actionAddDisinfectant()
    {
        $model = new DisinfectantForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->disinfectantService->addDisinfectant($model->fillDisinfectant());
            $this->redirect('manage-disinfectants');
        }

        return $this->render('add-disinfectant', compact('model'));
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
                        'actions'=> ['manage-disinfectants', 'manage-disinfectants-on-customers',
                            'manage-customer-disinfectant', 'edit-disinfectant', 'delete-disinfectant',
                            'add-disinfectant'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
