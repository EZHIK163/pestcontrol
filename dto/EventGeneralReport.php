<?php
namespace app\dto;

/**
 * Class EventGroupByMonth
 * @package app\dto
 */
class EventGeneralReport
{
    /**
     * @var string
     */
    private $statusCode;

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     * @return EventGeneralReport
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'code'  => $this->statusCode
        ];
    }
}
