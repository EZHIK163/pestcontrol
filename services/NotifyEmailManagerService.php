<?php
namespace app\services;

use app\dto\CallEmployee;
use Yii;

/**
 * Class NotifyManagerService
 * @package app\services
 */
class NotifyEmailManagerService
{
    /**
     * @param CallEmployee $callEmployee
     * @return void
     */
    public function notifyManagerFromCallEmployee($callEmployee)
    {
        $toEmailArray = Yii::$app->params['email_notify'];

        $from = Yii::$app->params['email_from'];

        $subject = 'Вызов сотрудника PestControl клиентом ' .
            $callEmployee->getCustomer()->getName() . ': ' . $callEmployee->getTitle();

        $body = 'Клиент ' . $callEmployee->getCustomer()->getName() . ' пишет: ' .
            $callEmployee->getMessage() . '. Email: ' . $callEmployee->getEmail();

        if ($callEmployee->isSendCopy()) {
            $toEmailArray [] = $callEmployee->getEmail();
        }

        foreach ($toEmailArray as $to) {
            Yii::$app->mailer->compose()
                ->setFrom($from)
                ->setTo($to)
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
        }
    }
}
