<?php
namespace app\dto;

/**
 * Class Point
 * @package app\dto
 */
class Point
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
     * @var FileCustomer
     */
    private $fileCustomer;
    /**
     * @var int
     */
    private $idInternal;
    /**
     * @var string
     */
    private $title;
    /**
     * @var float
     */
    private $xCoordinate;
    /**
     * @var float
     */
    private $yCoordinate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Point
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return FileCustomer
     */
    public function getFileCustomer()
    {
        return $this->fileCustomer;
    }

    /**
     * @param FileCustomer $fileCustomer
     * @return Point
     */
    public function setFileCustomer($fileCustomer)
    {
        $this->fileCustomer = $fileCustomer;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdInternal()
    {
        return $this->idInternal;
    }

    /**
     * @param int $idInternal
     * @return Point
     */
    public function setIdInternal($idInternal)
    {
        $this->idInternal = $idInternal;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Point
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getXCoordinate()
    {
        return $this->xCoordinate;
    }

    /**
     * @param float $xCoordinate
     * @return Point
     */
    public function setXCoordinate($xCoordinate)
    {
        $this->xCoordinate = $xCoordinate;

        return $this;
    }

    /**
     * @return float
     */
    public function getYCoordinate()
    {
        return $this->yCoordinate;
    }

    /**
     * @param float $yCoordinate
     * @return Point
     */
    public function setYCoordinate($yCoordinate)
    {
        $this->yCoordinate = $yCoordinate;

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
     * @return Point
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
            'file'          => $this->fileCustomer->toArray(),
            'id_internal'   => $this->idInternal,
            'title'         => $this->title,
            'x_coordinate'  => $this->xCoordinate,
            'y_coordinate'  => $this->yCoordinate
        ];
    }
}
