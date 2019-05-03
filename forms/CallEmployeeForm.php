<?php
namespace app\forms;

use app\dto\CallEmployee;
use yii\base\Model;
use yii\validators\EmailValidator;

/**
 * Class CallEmployeeForm
 * @package app\forms
 */
class CallEmployeeForm extends Model
{
    /**
     * @var string
     */
    public $fullName;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $message;
    /**
     * @var bool
     */
    public $isSendCopy;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullName', 'email', 'title', 'message'], 'required'],
            ['isSendCopy', 'boolean'],
            ['email', 'email'],
            ['isSendCopy', 'default', 'value'   => false],
        ];
    }

    /**
     * @return bool
     */
    public function validateEmail()
    {
        $emailValidator = new EmailValidator();
        $emailValidator->checkDNS = true;

        $result = $emailValidator->validate($this->email, $errors);

        if (!empty($errors)) {
            $this->addError('email', 'Значение «' . $this->attributeLabels()['email'] . '» не является правильным email адресом');
        }

        return $result;
    }

    /**
     * @return CallEmployee
     */
    public function fillCallEmployee()
    {
        $callEmployee = (new CallEmployee())
            ->setFullName(($this->fullName))
            ->setTitle($this->title)
            ->setEmail($this->email)
            ->setMessage($this->message)
            ->setIsSendCopy($this->isSendCopy);

        return $callEmployee;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'fullName'      => 'Имя',
            'email'         => 'Email',
            'title'         => 'Тема',
            'message'       => 'Сообщение',
            'isSendCopy'    => 'Отправлять копию письма на указанный email',
        ];
    }
}
