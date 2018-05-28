<?php
namespace app\models\customer;

use yii\base\Model;

class ManagePointForm extends Model {

    public $id_scheme_point_control;
    public $title;
    public $x_coordinate;
    public $y_coordinate;
    public $id_point;

    public function rules()
    {
        return [
            [['id_scheme_point_control', 'title', 'x_coordinate', 'y_coordinate'], 'required']
        ];
    }

    function __construct($id_point)
    {
        $this->id_point = $id_point;
        $point = Points::getItemForEditing($id_point);
        $this->x_coordinate = $point['x_coordinate'];
        $this->y_coordinate = $point['y_coordinate'];
        $this->title = $point['title'];
        $this->id_scheme_point_control = $point['id_file_customer'];
    }

    public function savePoint() {
        Points::saveItem($this->id_point, $this->x_coordinate,
            $this->y_coordinate, $this->title, $this->id_scheme_point_control);
    }

    public function attributeLabels()
    {
        return [
            'id_scheme_point_control' => 'Схема точек контроля'
        ];
    }
}