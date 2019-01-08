<?php
namespace app\dto;

/**
 * Class DisinfectantSelect
 * @package app\dto
 */
class DisinfectantSelect
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $isSelect;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return DisinfectantSelect
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSelect()
    {
        return $this->isSelect;
    }

    /**
     * @param bool $isSelect
     * @return DisinfectantSelect
     */
    public function setIsSelect($isSelect)
    {
        $this->isSelect = $isSelect;

        return $this;
    }
}
