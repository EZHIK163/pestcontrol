<?php

namespace app\dto;

/**
 * Модель вызова сотрудника
 */
class CallEmployee
{
    /** @var string */
    private $fullName;
    /** @var string */
    private $email;
    /** @var string */
    private $title;
    /** @var string */
    private $message;
    /** @var bool */
    private $isSendCopy;
    /** @var Customer */
    private $customer;

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return CallEmployee
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CallEmployee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CallEmployee
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return CallEmployee
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSendCopy()
    {
        return $this->isSendCopy;
    }

    /**
     * @param bool $isSendCopy
     * @return CallEmployee
     */
    public function setIsSendCopy($isSendCopy)
    {
        $this->isSendCopy = $isSendCopy;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return CallEmployee
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }
}
