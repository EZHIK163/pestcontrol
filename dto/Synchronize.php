<?php
namespace app\dto;

/**
 * Class Synchronize
 * @package app\dto
 */
class Synchronize
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $isActive;
    /**
     * @var int
     */
    private $countSyncRow;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Synchronize
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountSyncRow()
    {
        return $this->countSyncRow;
    }

    /**
     * @param int $countSyncRow
     * @return Synchronize
     */
    public function setCountSyncRow($countSyncRow)
    {
        $this->countSyncRow = $countSyncRow;

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
     * @return Synchronize
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
