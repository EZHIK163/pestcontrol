<?php
namespace app\models\customer;

use yii\base\Model;

class ManageDisinfectantForm extends Model {

    public $value;
    public $title;
    public $id_disinfectant;

    public function rules()
    {
        return [
            [['value', 'title'], 'required']
        ];
    }

    function __construct($id_disinfectant)
    {
        if (!is_null($id_disinfectant)) {
            $this->id_disinfectant = $id_disinfectant;
            $disinfectant = Disinfectant::getItemForEditing($id_disinfectant);
            $this->value = $disinfectant['value'];
            $this->title = $disinfectant['description'];
        } else {
            $this->value = '';
            $this->title = '';
        }
    }

    public function saveDisinfectant() {
        Disinfectant::saveItem($this->id_disinfectant, $this->title, $this->value);
    }

    public function addDisinfectant() {
        Disinfectant::addItem($this->title, $this->value);
    }

    public function attributeLabels()
    {
        return [
            'value' => 'Коэффициент',
            'title' => 'Наименование'
        ];
    }
}