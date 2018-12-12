<?php
namespace app\controllers;

use app\entities\CustomerRecord;
use app\entities\DisinfectantRecord;
use app\entities\DisinfectorRecord;
use app\entities\EventRecord;
use app\entities\FileCustomerRecord;
use app\entities\FileCustomerTypeRecord;
use app\models\customer\ManageDisinfectantForm;
use app\models\customer\ManageDisinfectantsForm;
use app\models\customer\ManageEventForm;
use app\models\customer\ManageEventsForm;
use app\models\customer\ManagePointForm;
use app\models\customer\ManagePointsForm;
use app\entities\PointRecord;
use app\entities\PointStatusRecord;
use app\models\customer\SearchForm;
use app\models\file\Files;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\widget\Widget;
use app\services\CustomerService;
use app\services\DisinfectantService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerDisinfectantController extends Controller
{
    private $manageDisinfectantsForm;
    private $customerService;
    private $manageDisinfectantForm;
    private $disinfectantService;

    /**
     * {@inheritdoc}
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (in_array($action->id, ['save-point', 'new-point', 'new-event', 'get-statuses'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param ManageDisinfectantsForm $manageDisinfectantsForm
     * @param ManageDisinfectantForm $manageDisinfectantForm
     * @param CustomerService $customerService
     * @param DisinfectantService $disinfectantService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        ManageDisinfectantsForm $manageDisinfectantsForm,
        ManageDisinfectantForm $manageDisinfectantForm,
        CustomerService $customerService,
        DisinfectantService $disinfectantService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->manageDisinfectantsForm = $manageDisinfectantsForm;
        $this->manageDisinfectantForm = $manageDisinfectantForm;
        $this->disinfectantService = $disinfectantService;
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

        $model = $this->manageDisinfectantsForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->updateDisinfectants($id);
        }

        $model->fetchDisinfectants($id);

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

        $model = $this->manageDisinfectantForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->saveDisinfectant($id);
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
        $model = $this->manageDisinfectantForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->addDisinfectant();

            $this->redirect('manage-disinfectants');
        }

        return $this->render('add-disinfectant', compact('model'));
    }

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
