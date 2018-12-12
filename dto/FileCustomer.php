<?php
namespace app\dto;

use DateTime;

/**
 * Class File
 * @package app\dto
 */
class FileCustomer
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
     * @var Customer
     */
    private $customer;
    /**
     * @var string
     */
    private $typeDescription;
    /**
     * @var
     */
    private $typeCode;
    /**
     * @var int
     */
    private $typeId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var File
     */
    private $file;
    /**
     * @var DateTime
     */
    private $createdAt;

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
     * @return FileCustomer
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @return FileCustomer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return FileCustomer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeDescription()
    {
        return $this->typeDescription;
    }

    /**
     * @param string $typeDescription
     * @return FileCustomer
     */
    public function setTypeDescription($typeDescription)
    {
        $this->typeDescription = $typeDescription;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * @param mixed $typeCode
     * @return FileCustomer
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;

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
     * @return FileCustomer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param int $TypeId
     * @return FileCustomer
     */
    public function setTypeId($TypeId)
    {
        $this->typeId = $TypeId;

        return $this;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return FileCustomer
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return FileCustomer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                    => $this->id,
            'customer'              => $this->customer->toArray(),
            'type_code'             => $this->typeCode,
            'type_description'      => $this->typeDescription,
            'file'                  => $this->file->toArray(),
            'date_create'           => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }
}
