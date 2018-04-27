<?php
namespace app\models\customer;

use yii\base\Model;
use yii\web\UploadedFile;

class OccupancyForm extends Model
{

    /**
     * @var UploadedFile
     */
    public $date_from;

    public $date_to;

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'required']
        ];
    }

    /**
     * @return array|bool
     */
    public function getDate()
    {
        if (!$this->validate()) {
            return [];
        }

        $scheme_point_control = FileCustomer::getSchemePointControlForAdmin($this->query);
        return $scheme_point_control;
    }

    public function attributeLabels()
    {
        return [
            'date_from' => 'Дата начала отчета',
            'date_to' => 'Дата окончания отчета'
        ];
    }


}