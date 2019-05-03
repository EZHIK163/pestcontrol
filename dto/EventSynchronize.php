<?php

namespace app\dto;

/**
 * Модель данных используемая при синхронизации данных из старой БД
 */
class EventSynchronize
{
    /** @var int */
    private $idDisinfector;
    /** @var int */
    private $idCustomer;
    /** @var int */
    private $idExternal;
    /** @var int */
    private $idPointStatus;
    /** @var int */
    private $createdAt;
    /** @var int */
    private $createdBy;
    /** @var int */
    private $updatedAt;
    /** @var int */
    private $updatedBy;

    /**
     * @return int
     */
    public function getIdDisinfector()
    {
        return $this->idDisinfector;
    }

    /**
     * @param int $idDisinfector
     * @return EventSynchronize
     */
    public function setIdDisinfector($idDisinfector)
    {
        $this->idDisinfector = $idDisinfector;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    /**
     * @param int $idCustomer
     * @return EventSynchronize
     */
    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;

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
     * @return EventSynchronize
     */
    public function setIdExternal($idExternal)
    {
        $this->idExternal = $idExternal;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdPointStatus()
    {
        return $this->idPointStatus;
    }

    /**
     * @param int $idPointStatus
     * @return EventSynchronize
     */
    public function setIdPointStatus($idPointStatus)
    {
        $this->idPointStatus = $idPointStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     * @return EventSynchronize
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return EventSynchronize
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     * @return EventSynchronize
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     * @return EventSynchronize
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
