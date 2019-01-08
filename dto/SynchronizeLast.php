<?php
namespace app\dto;

/**
 * Class Synchronize
 * @package app\dto
 */
class SynchronizeLast
{
    /**
     * @var \DateTime
     */
    private $dateTimeLastSync;

    /**
     * @return \DateTime
     */
    public function getDateTimeLastSync()
    {
        return $this->dateTimeLastSync;
    }

    /**
     * @param \DateTime $dateTimeLastSync
     * @return SynchronizeLast
     */
    public function setDateTimeLastSync($dateTimeLastSync)
    {
        $this->dateTimeLastSync = $dateTimeLastSync;

        return $this;
    }
}
