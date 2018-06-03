<?php
namespace app\models\customer;

use yii\base\Model;

class ManageDisinfectantForm extends Model {

    public $value;
    public $title;
    public $id_disinfectant;

    public $form_of_facility;
    public $active_substance;
    public $concentration_of_substance;
    public $manufacturer;
    public $terms_of_use;
    public $place_of_application;

    public function rules()
    {
        return [
            [['value', 'title', 'form_of_facility',
                'active_substance', 'manufacturer',
                'terms_of_use', 'place_of_application'], 'required']
        ];
    }

    function __construct($id_disinfectant)
    {
        if (!is_null($id_disinfectant)) {
            $this->id_disinfectant = $id_disinfectant;
            $disinfectant = Disinfectant::getItem($id_disinfectant);
            $this->value = $disinfectant['value'];
            $this->title = $disinfectant['description'];
            $this->form_of_facility = $disinfectant['form_of_facility'];
            $this->active_substance = $disinfectant['active_substance'];
            $this->concentration_of_substance = $disinfectant['concentration_of_substance'];
            $this->manufacturer = $disinfectant['manufacturer'];
            $this->terms_of_use = $disinfectant['terms_of_use'];
            $this->place_of_application = $disinfectant['place_of_application'];

        } else {
            $this->value = '';
            $this->title = '';
            $this->form_of_facility = '';
            $this->active_substance = '';
            $this->concentration_of_substance = '';
            $this->manufacturer = '';
            $this->terms_of_use = '';
            $this->place_of_application = '';
        }
    }

    public function saveDisinfectant() {
        Disinfectant::saveItem($this->id_disinfectant, $this->title, $this->value,
            $this->form_of_facility, $this->active_substance,
            $this->concentration_of_substance, $this->manufacturer,
            $this->terms_of_use, $this->place_of_application);
    }

    public function addDisinfectant() {
        Disinfectant::addItem($this->title, $this->value, $this->form_of_facility, $this->active_substance,
            $this->concentration_of_substance, $this->manufacturer,
            $this->terms_of_use, $this->place_of_application);
    }

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