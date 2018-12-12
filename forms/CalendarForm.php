<?php
namespace app\forms;

use yii\base\Model;

/**
 * Class CalendarForm
 * @package app\forms
 */
class CalendarForm extends Model
{
    /**
     * Date format d.m.y
     * @var string
     */
    public $dateFrom;

    /**
     * Date format d.m.y
     *
     * @var string
     */
    public $dateTo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dateFrom'  => 'Дата начала отчета',
            'dateTo'    => 'Дата окончания отчета'
        ];
    }
}
