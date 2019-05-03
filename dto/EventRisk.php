<?php

namespace app\dto;

/**
 * Модель для отчета по рискам
 */
class EventRisk
{
    /** @var int */
    private $idExternal;

    /**
     * @return int
     */
    public function getIdExternal()
    {
        return $this->idExternal;
    }

    /**
     * @param int $idExternal
     * @return EventRisk
     */
    public function setIdExternal($idExternal)
    {
        $this->idExternal = $idExternal;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id_external'   => $this->idExternal
        ];
    }
}
