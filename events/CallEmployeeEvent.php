<?php
namespace app\events;

use app\dto\CallEmployee;
use app\services\NotifyEmailManagerService;
use yii\base\Event;

/**
 * Событие вызова сотрудника из личного кабинета
 */
class CallEmployeeEvent extends Event
{
    const CALL_EMPLOYEE_EVENT = 'call-employee-event';

    /** @var CallEmployee */
    public $callEmployee;
    /** @var NotifyEmailManagerService */
    private $notifyManagerService;

    /**
     * @param NotifyEmailManagerService $notifyManagerService
     * @param array $config
     */
    public function __construct(NotifyEmailManagerService $notifyManagerService, array $config = [])
    {
        $this->notifyManagerService = $notifyManagerService;
        parent::__construct($config);
    }

    /**
     * Оповещение менеджера о новом запросе
     */
    public function notify()
    {
        $this->notifyManagerService->notifyManagerFromCallEmployee($this->callEmployee);
    }
}
