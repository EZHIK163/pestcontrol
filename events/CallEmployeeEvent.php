<?php
namespace app\events;

use app\dto\CallEmployee;
use app\services\NotifyEmailManagerService;
use yii\base\Event;

/**
 * Class CallEmployeeEvent
 * @package app\events
 */
class CallEmployeeEvent extends Event
{
    const CALL_EMPLOYEE_EVENT = 'call-employee-event';

    /**
     * @var CallEmployee
     */
    public $callEmployee;
    /**
     * @var NotifyEmailManagerService
     */
    private $notifyManagerService;

    /**
     * CallEmployeeEvent constructor.
     * @param NotifyEmailManagerService $notifyManagerService
     * @param array $config
     */
    public function __construct(NotifyEmailManagerService $notifyManagerService, array $config = [])
    {
        $this->notifyManagerService = $notifyManagerService;
        parent::__construct($config);
    }

    /**
     * Notify manager about new calling
     */
    public function notify()
    {
        $this->notifyManagerService->notifyManagerFromCallEmployee($this->callEmployee);
    }
}
