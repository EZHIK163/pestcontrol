<?php
namespace app\controllers;

use app\forms\SearchSchemeForm;
use app\components\Widget;
use app\forms\UploadFileForm;
use app\services\CustomerService;
use app\services\FileCustomerService;
use app\services\FileService;
use app\tools\Tools;
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
class ManagerFileController extends Controller
{
    private $customerService;
    private $fileService;
    private $fileCustomerService;
    private $searchForm;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param FileService $fileService
     * @param FileCustomerService $fileCustomerService
     * @param UploadFileForm $uploadForm
     * @param SearchSchemeForm $searchForm
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        FileService $fileService,
        FileCustomerService $fileCustomerService,
        SearchSchemeForm $searchForm,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->fileService = $fileService;
        $this->fileCustomerService = $fileCustomerService;
        $this->searchForm = $searchForm;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionUploadFiles()
    {
        $model = new UploadFileForm();

        $supportExtensions = $this->fileService->getSupportExtensions();
        $model->setSupportExtension($supportExtensions);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $this->fileService->saveFilesFromUpload($model->uploadedFiles, $model->idCustomer, $model->idFileCustomerType);

            if ($result) {
                $code = $this->fileCustomerService->getCodeById($model->idFileCustomerType);
                $action = null;
                switch ($code) {
                    case 'recommendations':
                        $action = 'recommendations';
                        break;
                    case 'scheme_point_control':
                        $action = 'scheme-point-control';
                        break;
                }
                $this->redirect($action);
            }
        }

        $types = $this->fileCustomerService->getFileCustomerTypesForDropDownList();

        $customers = $this->customerService->getCustomerForDropDownList();

        return $this->render(
            'upload_files',
            [
                'model'                 => $model,
                'file_customer_types'   => $types,
                'customers'             => $customers
            ]
        );
    }

    /**
     * @return string
     */
    public function actionRecommendations()
    {
        $recommendations = $this->fileCustomerService->getRecommendationsForAdmin();
        $data_provider = Tools::wrapIntoDataProvider($recommendations);
        return $this->render('recommendations', compact('data_provider'));
    }

    /**
     * @throws \Throwable
     * @throws \app\exceptions\FileCustomerNotFound
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteRecommendation()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $this->fileService->deleteFile($id);
        $this->redirect('recommendations');
    }

    /**
     * @return string
     */
    public function actionSchemePointControl()
    {
        $model = new SearchSchemeForm();

        $model->load(Yii::$app->request->post());
        $model->validate();

        $schemePointControl = $this->fileCustomerService->getSchemePointControlForAdmin($model->query);

        $dataProvider = Tools::wrapIntoDataProvider($schemePointControl);
        return $this->render('scheme-point-control', ['data_provider'   => $dataProvider, 'model'  => $model]);
    }

    /**
     * @return string
     */
    public function actionEditSchemaPointControl()
    {
        $id_scheme_point_control = (int)Yii::$app->request->get('id');
        if (!isset($id_scheme_point_control) or $id_scheme_point_control === 0) {
            throw new InvalidArgumentException();
        }
        return $this->render('edit-schema-point-control', compact('id_scheme_point_control'));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionGetPointsOnSchemaPointControl()
    {
        $id_file = Yii::$app->request->get('id_scheme_point_control');
        $is_show_free_points = Yii::$app->request->get('is_show_free_points');
        $date_from = Yii::$app->request->get('date_from');
        $date_to = Yii::$app->request->get('date_to');

        $is_show_free_points = $is_show_free_points === 'true' ? true : false;

        if (!isset($id_file) or $id_file === 0) {
            throw new InvalidArgumentException();
        }

        $my_data = $this->fileCustomerService->getSchemeForEdit($id_file, $is_show_free_points, $date_from, $date_to);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $my_data;
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
                        'actions'=> ['upload-files','recommendations','delete-recommendation',
                            'scheme-point-control', 'edit-schema-point-control'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'=> ['get-points-on-schema-point-control'],
                        'roles'     => [],
                        'allow'     => true
                    ]
                ]
            ],
        ];
    }
}
