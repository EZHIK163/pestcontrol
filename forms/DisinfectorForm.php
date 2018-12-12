<?php
namespace app\forms;

use app\dto\Disinfector;
use yii\base\Model;

/**
 * Class DisinfectorForm
 * @package app\forms
 */
class DisinfectorForm extends Model
{
    public $fullName;
    public $phone;
    public $id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullName', 'phone', 'id'], 'required']
        ];
    }

    /**
     * @param Disinfector $disinfector
     */
    public function fillThis($disinfector)
    {
        $this->id = $disinfector->getId();
        $this->fullName = $disinfector->getFullName();
        $this->phone = $disinfector->getPhone();
    }

    /**
     * @return Disinfector
     */
    public function fillDisinfector()
    {
        $disinfector = (new Disinfector())
            ->setId($this->id)
            ->setFullName($this->fullName)
            ->setPhone($this->phone);

        return $disinfector;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                 => 'ID',
            'fullName'           => 'ФИО',
            'phone'              => 'Номер телефона',
        ];
    }
}
