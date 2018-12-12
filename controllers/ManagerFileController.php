<?php
namespace app\controllers;

use app\models\customer\SearchForm;
use app\models\file\Files;
use app\models\file\UploadForm;
use app\models\tools\Tools;
use app\models\user\User;
use app\models\widget\Widget;
use app\services\CustomerService;
use app\services\FileCustomerService;
use app\services\FileService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerFileController extends Controller
{
    private $customerService;
    private $fileService;
    private $fileCustomerService;
    private $uploadForm;
    private $searchForm;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param FileService $fileService
     * @param FileCustomerService $fileCustomerService
     * @param UploadForm $uploadForm
     * @param SearchForm $searchForm
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        FileService $fileService,
        FileCustomerService $fileCustomerService,
        UploadForm $uploadForm,
        SearchForm $searchForm,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->fileService = $fileService;
        $this->fileCustomerService = $fileCustomerService;
        $this->uploadForm = $uploadForm;
        $this->searchForm = $searchForm;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionUploadFiles()
    {
        $model = $this->uploadForm;

        if (Yii::$app->request->isPost) {
            $model->uploadedFiles = UploadedFile::getInstances($model, 'uploadedFiles');
            $model->id_customer = Yii::$app->request->post('UploadForm')['id_customer'];
            $model->id_file_customer_type = Yii::$app->request->post('UploadForm')['id_file_customer_type'];
            if ($model->upload()) {
                $action = $model->getViewAfterUpload();
                $this->redirect($action);
            }
        }

        $file_customer_types = $this->fileCustomerService->getFileCustomerTypesForDropDownList();

        $customers = $this->customerService->getCustomerForDropDownList();

        return $this->render('upload_files', compact('model', 'file_customer_types', 'customers'));
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
     *
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
        $model = $this->searchForm;

        if (Yii::$app->request->isPost) {
            $model->query = Yii::$app->request->post('SearchForm')['query'];
        }

        $scheme_point_control = $model->getResultsForAdmin();

        $data_provider = Tools::wrapIntoDataProvider($scheme_point_control);
        return $this->render('scheme-point-control', compact('data_provider', 'model'));
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
