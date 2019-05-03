<?php
namespace app\controllers;

use app\components\MainWidget;
use app\forms\SchemeRenameForm;
use app\forms\SearchSchemeForm;
use app\forms\UploadFileForm;
use app\services\CustomerService;
use app\services\FileCustomerService;
use app\services\FileService;
use app\tools\Tools;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerFileController extends Controller
{
    /** @var CustomerService */
    private $customerService;
    /** @var FileService */
    private $fileService;
    /** @var FileCustomerService */
    private $fileCustomerService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param FileService $fileService
     * @param FileCustomerService $fileCustomerService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        FileService $fileService,
        FileCustomerService $fileCustomerService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->fileService = $fileService;
        $this->fileCustomerService = $fileCustomerService;
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

        if ($model->load(Yii::$app->request->post())) {
            $model->uploadedFiles = UploadedFile::getInstances($model, 'uploadedFiles');
            $result = $this->fileService->saveFilesFromUpload(
                $model->uploadedFiles,
                $model->idCustomer,
                $model->idFileCustomerType
            );

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
        $idSchemaPointControl = (int)Yii::$app->request->get('id');
        if (!isset($idSchemaPointControl) or $idSchemaPointControl === 0) {
            throw new InvalidArgumentException();
        }

        $scheme = $this->fileCustomerService->getSchemeForStat($idSchemaPointControl);
        $title = $scheme['title'];

        return $this->render('edit-schema-point-control', compact('idSchemaPointControl', 'title'));
    }

    /**
     * @return string
     */
    public function actionEditTitleSchemaPointControl()
    {
        $id = (int)Yii::$app->request->get('id');
        if (!isset($id) or $id === 0) {
            throw new InvalidArgumentException();
        }

        $model = new SchemeRenameForm();

        $isSuccess = false;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $this->fileCustomerService->renameFileCustomer($model->id, $model->title);
            $isSuccess = true;
        }

        $scheme = $this->fileCustomerService->getSchemeForStat($id);
        $title = $scheme['title'];

        $model->fill($id, $title);

        return $this->render('edit-title-schema-point-control', compact('model', 'isSuccess'));
    }

    /**
     *
     */
    public function actionDeleteSchemaPointControl()
    {
        $id = (int)Yii::$app->request->get('id');

        if (!isset($id) or $id === 0) {
            throw new InvalidArgumentException();
        }

        $this->fileCustomerService->deleteFile($id);

        $this->redirect('scheme-point-control');
    }

    /**
     * @throws \Exception
     * @return array
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

        $data = $this->fileCustomerService->getPointsForScheme($id_file, $is_show_free_points, $date_from, $date_to);
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $data;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render($view, $params = [])
    {
        $params = array_merge($params, MainWidget::getWidgetsForAccount());

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
                            'scheme-point-control', 'edit-schema-point-control', 'delete-schema-point-control',
                            'edit-title-schema-point-control'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                    [
                        'actions'   => ['get-points-on-schema-point-control'],
                        'roles'     => [],
                        'allow'     => true
                    ]
                ]
            ],
        ];
    }
}
