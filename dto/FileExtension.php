<?php

namespace app\dto;

/**
 * Модель расширения файла
 */
class FileExtension
{
    /** @var int */
    private $id;
    /** @var bool */
    private $isActive;
    /** @var string */
    private $description;
    /** @var string */
    private $extension;
    /** @var string */
    private $typeDescription;
    /** @var string */
    private $typeCode;
    /** @var int */
    private $typeId;
    /** @var string */
    private $pathToFolder;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FileExtension
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
     * @return FileExtension
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

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
     * @return FileExtension
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return FileExtension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

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
     * @return FileExtension
     */
    public function setTypeDescription($typeDescription)
    {
        $this->typeDescription = $typeDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeCode()
    {
        return $this->typeCode;
    }

    /**
     * @param string $typeCode
     * @return FileExtension
     */
    public function setTypeCode($typeCode)
    {
        $this->typeCode = $typeCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPathToFolder()
    {
        return $this->pathToFolder;
    }

    /**
     * @param string $pathToFolder
     * @return FileExtension
     */
    public function setPathToFolder($pathToFolder)
    {
        $this->pathToFolder = $pathToFolder;

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
     * @param int $typeId
     * @return FileExtension
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                => $this->id,
            'description'       => $this->description,
            'type_description'  => $this->typeDescription,
            'type_code'         => $this->typeCode,
            'path_to_folder'    => $this->pathToFolder,
            'extension'         => $this->extension
        ];
    }
}
