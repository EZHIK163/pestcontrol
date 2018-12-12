<?php
namespace app\dto;

use DateTime;

/**
 * Class Event
 * @package app\dto
 */
class EventSynchronize
{
    /**
     * @var int
     */
    private $id_disinfector;
    /**
     * @var int
     */
    private $id_customer;
    /**
     * @var int
     */
    private $id_external;
    /**
     * @var int
     */
    private $id_point_status;
    /**
     * @var int
     */
    private $created_at;
    /**
     * @var int
     */
    private $created_by;
    /**
     * @var int
     */
    private $updated_at;
    /**
     * @var int
     */
    private $updated_by;

    /**
     * @return int
     */
    public function getIdDisinfector()
    {
        return $this->id_disinfector;
    }

    /**
     * @param int $id_disinfector
     * @return EventSynchronize
     */
    public function setIdDisinfector($id_disinfector)
    {
        $this->id_disinfector = $id_disinfector;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdCustomer()
    {
        return $this->id_customer;
    }

    /**
     * @param int $id_customer
     * @return EventSynchronize
     */
    public function setIdCustomer($id_customer)
    {
        $this->id_customer = $id_customer;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdExternal()
    {
        return $this->id_external;
    }

    /**
     * @param int $id_external
     * @return EventSynchronize
     */
    public function setIdExternal($id_external)
    {
        $this->id_external = $id_external;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdPointStatus()
    {
        return $this->id_point_status;
    }

    /**
     * @param int $id_point_status
     * @return EventSynchronize
     */
    public function setIdPointStatus($id_point_status)
    {
        $this->id_point_status = $id_point_status;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param int $created_at
     * @return EventSynchronize
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param int $created_by
     * @return EventSynchronize
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param int $updated_at
     * @return EventSynchronize
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param int $updated_by
     * @return EventSynchronize
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;

        return $this;
    }

}
