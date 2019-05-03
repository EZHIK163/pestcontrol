<?php
namespace app\controllers;

use app\components\MainWidget;
use app\forms\LoginForm;
use app\services\FileService;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Содержит публичные методы доступные не авторизованному клиенту
 */
class SiteController extends Controller
{
    /** @var FileService */
    private $fileService;

    /**
     * @param $id
     * @param Module $module
     * @param FileService $fileService
     * @param array $config
     */
    public function __construct($id, Module $module, FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (!(Yii::$app->user->isGuest)) {
            $this->redirect('account/index');
        }
        $model = new LoginForm();

        $widget = MainWidget::getSiteWidget();

        return $this->render('index', compact('model', 'widget'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) and $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', compact('model'));
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDownload()
    {
        $id = Yii::$app->request->get('id');
        $file = $this->fileService->getInfoForDownloadById($id);
        $url = $file['url'];
        $name = $file['name'];

        if (ob_get_level()) {
            ob_end_clean();
        }

        Yii::$app->response->sendFile($url, $name);
        Yii::$app->response->send();
    }

    /**
     * @return string
     */
    public function actionInformationAboutTheServiceProvider()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('information-about-the-service-provider', $params);
    }

    /**
     * @return string
     */
    public function actionLicensesAndCertificates()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('licenses-and-certificates', $params);
    }

    /**
     * @return string
     */
    public function actionListOfDisinfectants()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('list-of-disinfectants', $params);
    }

    /**
     * @return string
     */
    public function actionCertificatesOfDisinfectants()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('certificates-of-disinfectants', $params);
    }

    /**
     * @return string
     */
    public function actionDocumentsForEmployees()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('documents-for-employees', $params);
    }

    /**
     * @return string
     */
    public function actionContacts()
    {
        $params = MainWidget::getWidgetsForAccount();

        return $this->render('contacts', $params);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'    => [
                'class' => AccessControl::class,
                'only'  => ['login', 'logout'],
                'rules' => [
                    [
                        'actions'   => ['login'],
                        'roles'     => ['?'],
                        'allow'     => true
                    ],
                    [
                        'actions'   => ['logout'],
                        'roles'     => ['customer'],
                        'allow'     => true
                    ]
                ]
            ]
        ];
    }
}
