<?php
namespace app\forms;

use app\dto\Point;
use yii\base\Model;

/**
 * Class ManagePointForm
 * @package app\forms
 */
class PointForm extends Model
{
    public $idSchemePointControl;
    public $title;
    public $xCoordinate;
    public $yCoordinate;
    public $idPoint;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSchemePointControl', 'title', 'xCoordinate', 'yCoordinate', 'idPoint'], 'required']
        ];
    }

    /**
     * @param Point $point
     */
    public function fillThis($point)
    {
        $this->idPoint = $point->getId();
        $this->xCoordinate = $point->getXCoordinate();
        $this->yCoordinate = $point->getYCoordinate();
        $this->title = $point->getTitle();
        $this->idSchemePointControl = $point->getFileCustomer()->getId();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idSchemePointControl' => 'Схема точек контроля'
        ];
    }
}
