<?php
namespace app\dto;

/**
 * Class UserRole
 * @package app\dto
 */
class UserRole
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserRole
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return UserRole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'name'          => $this->name,
            'description'   => $this->description
        ];
    }
}
