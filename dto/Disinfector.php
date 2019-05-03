<?php

namespace app\dto;

/**
 * Модель дезинфектора
 */
class Disinfector
{
    /** @var int */
    private $id;
    /** @var bool */
    private $isActive;
    /** @var string */
    private $fullName;
    /** @var string */
    private $phone;

    public function __construct()
    {
        $this->isActive = true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Disinfector
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     * @return Disinfector
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Disinfector
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Disinfector
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->id,
            'phone'     => $this->phone,
            'full_name' => $this->fullName
        ];
    }
}
