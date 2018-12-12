<?php
namespace app\models\customer;

use app\dto\Point;
use yii\base\Model;

/**
 * Class ManagePointForm
 * @package app\models\customer
 */
class ManagePointForm extends Model
{
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

    /**
     * @param Point $point
     */
    public function fillThis($point)
    {
        $this->id_point = $point->getId();
        $this->x_coordinate = $point->getXCoordinate();
        $this->y_coordinate = $point->getYCoordinate();
        $this->title = $point->getTitle();
        $this->id_scheme_point_control = $point->getFileCustomer()->getId();
    }

    public function attributeLabels()
    {
        return [
            'id_scheme_point_control' => 'Схема точек контроля'
        ];
    }
}
