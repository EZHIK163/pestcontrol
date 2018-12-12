<?php
namespace app\dto;

/**
 * Class File
 * @package app\dto
 */
class FileCustomerType
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $code;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FileCustomerType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function isDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return FileCustomerType
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
     * @return FileCustomerType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'               => $this->id,
            'description'      => $this->description,
            'code'             => $this->code,
        ];
    }
}
