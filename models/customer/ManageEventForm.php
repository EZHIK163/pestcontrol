<?php
namespace app\models\customer;

use yii\base\Model;

class ManageEventForm extends Model {

    public $id_event;
    public $id_point_status;

    public function rules()
    {
        return [
            [['id_event', 'id_point_status'], 'required']
        ];
    }

    function __construct($id_event)
    {
        $this->id_event = $id_event;
        $event = Events::getItemForEditing($id_event);
        $this->id_point_status = $event['id_point_status'];
    }

    public function saveEvent() {
        Events::saveItem($this->id_event, $this->id_point_status);
    }

    public function attributeLabels()
    {
        return [
            'id_point_status' => 'Статус события'
        ];
    }
}