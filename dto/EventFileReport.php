<?php
namespace app\dto;

/**
 * Class EventFileReport
 * @package app\dto
 */
class EventFileReport
{
    /**
     * @var int
     */
    private $idExternal;
    /**
     * @var \DateTime
     */
    private $createdAt;
    /**
     * @var int
     */
    private $count;
    /**
     * @var string
     */
    private $statusCode;
    /** @var string */
    private $titleScheme;

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     * @return EventFileReport
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

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
     * @return EventFileReport
     */
    public function setIdExternal($idExternal)
    {
        $this->idExternal = $idExternal;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return EventFileReport
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @return EventFileReport
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitleScheme()
    {
        return $this->titleScheme;
    }

    /**
     * @param string $titleScheme
     * @return EventFileReport
     */
    public function setTitleScheme($titleScheme)
    {
        $this->titleScheme = $titleScheme;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'code'          => $this->statusCode,
            'id_external'   => $this->idExternal,
            'created_at'    => $this->getCreatedAt()->format('m'),
            'count'         => $this->count,
            'title_scheme'  => $this->titleScheme,
        ];
    }
}
