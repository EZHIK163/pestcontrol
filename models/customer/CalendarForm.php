<?php
namespace app\models\customer;

use yii\base\Model;
use yii\web\UploadedFile;

class CalendarForm extends Model
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

    public function attributeLabels()
    {
        return [
            'date_from' => 'Дата начала отчета',
            'date_to' => 'Дата окончания отчета'
        ];
    }
}
