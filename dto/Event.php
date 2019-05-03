<?php

namespace app\dto;

use DateTime;

/**
 * Модель события
 */
class Event
{
    /** @var int */
    private $id;
    /** @var bool */
    private $isActive;
    /** @var Customer */
    private $customer;
    /** @var Disinfector */
    private $disinfector;
    /** @var int */
    private $idExternal;
    /** @var Point */
    private $point;
    /** @var PointStatus */
    private $pointStatus;
    /** @var int */
    private $count;
    /** @var DateTime */
    private $createdAt;

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
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return Event
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

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
     * @return Event
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Disinfector
     */
    public function getDisinfector()
    {
        return $this->disinfector;
    }

    /**
     * @param Disinfector $disinfector
     * @return Event
     */
    public function setDisinfector($disinfector)
    {
        $this->disinfector = $disinfector;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdExternal()
    {
        return $this->idExternal;
    }

    /**
     * @param int $idExternal
     * @return Event
     */
    public function setIdExternal($idExternal)
    {
        $this->idExternal = $idExternal;

        return $this;
    }

    /**
     * @return Point
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * @param Point $point
     * @return Event
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return Event
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return PointStatus
     */
    public function getPointStatus()
    {
        return $this->pointStatus;
    }

    /**
     * @param PointStatus $pointStatus
     * @return Event
     */
    public function setPointStatus($pointStatus)
    {
        $this->pointStatus = $pointStatus;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'            => $this->id,
            'customer'      => $this->customer->toArray(),
            'disinfector'   => $this->disinfector->toArray(),
            'id_external'   => $this->idExternal,
            'point'         => $this->point !== null ? $this->point->toArray() : null,
            'point_status'  => $this->pointStatus->toArray(),
            'count'         => $this->count,
            'date_create'   => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }
}
