<?php
namespace app\models\customer;

use app\dto\Disinfectant;
use app\services\DisinfectantService;
use yii\base\Model;

/**
 * Class ManageDisinfectantForm
 * @package app\models\customer
 */
class ManageDisinfectantForm extends Model
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

    private $disinfectantService;

    public function rules()
    {
        return [
            [['value', 'title', 'formOfFacility',
                'activeSubstance', 'manufacturer',
                'termsOfUse', 'placeOfApplication', 'concentrationOfSubstance'], 'required']
        ];
    }

    /**
     * ManageDisinfectantForm constructor.
     * @param DisinfectantService $disinfectantService
     * @param array $config
     */
    public function __construct(DisinfectantService $disinfectantService, array $config = [])
    {
        $this->disinfectantService = $disinfectantService;

        parent::__construct($config);
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
     * @param $id
     */
    public function saveDisinfectant($id)
    {
        $disinfectant = $this->fillDisinfectant();
        $disinfectant->setId($id);
        $this->disinfectantService->saveDisinfectant($disinfectant);
    }

    /**
     *
     */
    public function addDisinfectant()
    {
        $this->disinfectantService->addDisinfectant($this->fillDisinfectant());
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
