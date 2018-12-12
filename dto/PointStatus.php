<?php
namespace app\dto;

/**
 * Class PointStatus
 * @package app\dto
 */
class PointStatus
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
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $code;

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
     * @return PointStatus
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return PointStatus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return PointStatus
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return PointStatus
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
            'id'            => $this->id,
            'description'   => $this->description,
            'code'          => $this->code
        ];
    }
}
