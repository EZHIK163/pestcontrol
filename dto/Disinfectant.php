<?php
namespace app\dto;

/**
 * Class Disinfectant
 * @package app\dto
 */
class Disinfectant
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
    private $code;
    /**
     * @var string
     */
    private $description;
    /**
     * @var float
     */
    private $value;
    /**
     * @var string
     */
    private $fromOfFacility;
    /**
     * @var string
     */
    private $activeSubstance;
    /**
     * @var string
     */
    private $concentrationOfSubstance;
    /**
     * @var string
     */
    private $manufacturer;
    /**
     * @var string
     */
    private $termsOfUse;
    /**
     * @var string
     */
    private $placeOfApplication;

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
     * @return Disinfectant
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
     * @return Disinfectant
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

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
     * @return Disinfectant
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return Disinfectant
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Disinfectant
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromOfFacility()
    {
        return $this->fromOfFacility;
    }

    /**
     * @param string $fromOfFacility
     * @return Disinfectant
     */
    public function setFromOfFacility($fromOfFacility)
    {
        $this->fromOfFacility = $fromOfFacility;

        return $this;
    }

    /**
     * @return string
     */
    public function getActiveSubstance()
    {
        return $this->activeSubstance;
    }

    /**
     * @param string $activeSubstance
     * @return Disinfectant
     */
    public function setActiveSubstance($activeSubstance)
    {
        $this->activeSubstance = $activeSubstance;

        return $this;
    }

    /**
     * @return string
     */
    public function getConcentrationOfSubstance()
    {
        return $this->concentrationOfSubstance;
    }

    /**
     * @param string $concentrationOfSubstance
     * @return Disinfectant
     */
    public function setConcentrationOfSubstance($concentrationOfSubstance)
    {
        $this->concentrationOfSubstance = $concentrationOfSubstance;

        return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     * @return Disinfectant
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return string
     */
    public function getTermsOfUse()
    {
        return $this->termsOfUse;
    }

    /**
     * @param string $termsOfUse
     * @return Disinfectant
     */
    public function setTermsOfUse($termsOfUse)
    {
        $this->termsOfUse = $termsOfUse;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfApplication()
    {
        return $this->placeOfApplication;
    }

    /**
     * @param string $placeOfApplication
     * @return Disinfectant
     */
    public function setPlaceOfApplication($placeOfApplication)
    {
        $this->placeOfApplication = $placeOfApplication;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'                            => $this->id,
            'description'                   => $this->description,
            'value'                         => $this->value,
            'from_of_facility'              => $this->fromOfFacility,
            'active_substance'              => $this->activeSubstance,
            'concentration_of_substance'    => $this->concentrationOfSubstance,
            'manufacturer'                  => $this->manufacturer,
            'terms_of_use'                  => $this->termsOfUse,
            'place_of_application'          => $this->placeOfApplication
        ];
    }
}
