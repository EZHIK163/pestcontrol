<?php

namespace app\dto;

/**
 * Модель для отчета заселенности
 */
class EventOccupancySchedule
{
    /** @var string */
    private $month;
    /** @var int*/
    private $count;

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $month
     * @return EventOccupancySchedule
     */
    public function setMonth($month)
    {
        $this->month = $month;

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
     * @return EventOccupancySchedule
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'month' => $this->month,
            'count' => (int)$this->count
        ];
    }
}
