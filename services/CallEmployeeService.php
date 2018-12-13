<?php
namespace app\services;

use app\dto\CallEmployee;
use app\events\CallEmployeeEvent;
use app\repositories\CustomerRepositoryInterface;
use Yii;

/**
 * Class CallEmployeeService
 * @package app\services
 */
class CallEmployeeService
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * CallEmployeeService constructor.
     * @param CustomerService $customerService
     */
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
        # Вешаем обработчик события на вызов сотрудника
        Yii::$app->on(CallEmployeeEvent::CALL_EMPLOYEE_EVENT, function (CallEmployeeEvent $event) {
            $event->notify();
        });
    }

    /**
     * @param CallEmployee $callEmployee
     * @param $idCustomer
     */
    public function call($callEmployee, $idCustomer)
    {
        $customer = $this->customerService->getCustomer($idCustomer);
        $callEmployee->setCustomer($customer);
        # Инициируем событие
        Yii::$app->trigger(
            CallEmployeeEvent::CALL_EMPLOYEE_EVENT,
            new CallEmployeeEvent(new NotifyEmailManagerService(), ['callEmployee' => $callEmployee])
        );
    }
}
