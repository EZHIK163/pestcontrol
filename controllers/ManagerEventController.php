<?php
namespace app\controllers;

use app\exceptions\PointNotFound;
use app\forms\EventForm;
use app\forms\EventsForm;
use app\tools\Tools;
use app\components\MainWidget;
use app\services\CustomerService;
use app\services\EventService;
use app\services\PointService;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Class ManagerController
 * @package app\controllers
 */
class ManagerEventController extends Controller
{
    private $customerService;
    private $eventService;
    private $pointService;

    /**
     * ManagerController constructor.
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param EventService $eventService
     * @param PointService $pointService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        EventService $eventService,
        PointService $pointService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->eventService = $eventService;
        $this->pointService = $pointService;
        parent::__construct($id, $module, $config);
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
     * @return string
     */
    public function actionManageEvents()
    {
        $model = new EventsForm();

        $model->load(Yii::$app->request->post());
        $model->validate();

        $customers = $this->customerService->getCustomerForDropDownList();

        $points = $this->eventService->getEventsForManager($model->idCustomer);

        $data_provider = Tools::wrapIntoDataProvider($points);
        return $this->render('manage-events', compact('data_provider', 'model', 'customers'));
    }

    /**
     *
     */
    public function actionDeleteEvent()
    {
        $id = Yii::$app->request->get('id');
        if (!isset($id)) {
            throw new InvalidArgumentException();
        }
        $this->eventService->deleteEvent($id);
        $this->redirect('manage-events');
    }

    /**
     * @return string
     */
    public function actionEditEvent()
    {
        $id = Yii::$app->request->get('id');

        if (!isset($id)) {
            throw new InvalidArgumentException();
        }

        $model = new EventForm();

        $event = $this->eventService->getItemForEditing($id);
        $model->fillThis($event);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->eventService->saveItem($model->idEvent, $model->idPointStatus);
        }

        $pointStatuses = $this->pointService->getPointStatusesForDropDownList();

        return $this->render(
            'manage-event',
            [
                'model'          => $model,
                'point_status'   => $pointStatuses
            ]
        );
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
                        'actions'=> ['manage-events', 'delete-event', 'edit-event'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
