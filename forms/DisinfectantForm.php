<?php
namespace app\forms;

use app\dto\Disinfectant;
use yii\base\Model;

/**
 * Class DisinfectantForm
 * @package app\forms
 */
class DisinfectantForm extends Model
{
    public $value;
    public $title;
    public $idDisinfectant;
    public $formOfFacility;
    public $activeSubstance;
    public $concentrationOfSubstance;
    public $manufacturer;
    public $termsOfUse;
    public $placeOfApplication;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'title', 'formOfFacility',
                'activeSubstance', 'manufacturer',
                'termsOfUse', 'placeOfApplication', 'concentrationOfSubstance'], 'required']
        ];
    }

    /**
     * @param Disinfectant $disinfectant
     */
    public function fillThis($disinfectant)
    {
        $this->idDisinfectant = $disinfectant->getId();
        $this->value = $disinfectant->getValue();
        $this->title = $disinfectant->getDescription();
        $this->formOfFacility = $disinfectant->getFormOfFacility();
        $this->activeSubstance = $disinfectant->getActiveSubstance();
        $this->concentrationOfSubstance = $disinfectant->getConcentrationOfSubstance();
        $this->manufacturer = $disinfectant->getManufacturer();
        $this->termsOfUse = $disinfectant->getTermsOfUse();
        $this->placeOfApplication = $disinfectant->getPlaceOfApplication();
    }

    /**
     * @return Disinfectant
     */
    public function fillDisinfectant()
    {
        $disinfectant = (new Disinfectant())
            ->setId($this->idDisinfectant)
            ->setValue($this->value)
            ->setDescription($this->title)
            ->setFromOfFacility($this->formOfFacility)
            ->setActiveSubstance($this->activeSubstance)
            ->setConcentrationOfSubstance($this->concentrationOfSubstance)
            ->setManufacturer($this->manufacturer)
            ->setTermsOfUse($this->termsOfUse)
            ->setPlaceOfApplication($this->placeOfApplication);

        return $disinfectant;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value'                         => 'Коэффициент',
            'title'                         => 'Наименование',
            'form_of_facility'              => 'Форма средства',
            'active_substance'              => 'Действующее вещество',
            'concentration_of_substance'    => 'Концетрация вещества',
            'manufacturer'                  => 'Производитель',
            'terms_of_use'                  => 'Условия применения',
            'place_of_application'          => 'Место применения'
        ];
    }
}
