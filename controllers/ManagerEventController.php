<?php
namespace app\controllers;

use app\components\MainWidget;
use app\exceptions\PointNotFound;
use app\forms\EventForm;
use app\forms\EventsForm;
use app\services\CustomerService;
use app\services\DisinfectorService;
use app\services\EventService;
use app\services\PointService;
use app\services\UserService;
use app\tools\Tools;
use InvalidArgumentException;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Методы по работе менеджера с событиями
 */
class ManagerEventController extends Controller
{
    /** @var CustomerService  */
    private $customerService;
    /** @var EventService  */
    private $eventService;
    /** @var PointService  */
    private $pointService;
    /** @var UserService */
    private $userService;
    /** @var DisinfectorService */
    private $disinfectorService;

    /**
     * @param $id
     * @param Module $module
     * @param CustomerService $customerService
     * @param EventService $eventService
     * @param PointService $pointService
     * @param UserService $userService
     * @param DisinfectorService $disinfectorService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CustomerService $customerService,
        EventService $eventService,
        PointService $pointService,
        UserService $userService,
        DisinfectorService $disinfectorService,
        array $config = []
    ) {
        $this->customerService = $customerService;
        $this->eventService = $eventService;
        $this->pointService = $pointService;
        $this->userService = $userService;
        $this->disinfectorService = $disinfectorService;

        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
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
     * @throws PointNotFound
     * @throws \app\exceptions\DisinfectorNotFound
     * @return string
     */
    public function actionAddEvent()
    {
        $model = new EventForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->eventService->addEvent(
                $model->idCustomer,
                $model->idDisinfector,
                $model->numberPoint,
                $model->idPointStatus,
                $model->countPoint
            );

            $this->redirect('manage-events');
        }

        $users = $this->userService->getUsersForDropDownList();
        $pointStatuses = $this->pointService->getPointStatusesForDropDownList();
        $customers = $this->customerService->getCustomerForDropDownList();
        $disinfectors = $this->disinfectorService->getForDropDownList();

        return $this->render('add-event', [
            'model'         => $model,
            'users'         => $users,
            'point_status'  => $pointStatuses,
            'customers'     => $customers,
            'disinfectors'  => $disinfectors
        ]);
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
                        'actions'   => ['manage-events', 'delete-event', 'edit-event', 'add-event'],
                        'roles'     => ['manager'],
                        'allow'     => true
                    ],
                ]
            ],
        ];
    }
}
