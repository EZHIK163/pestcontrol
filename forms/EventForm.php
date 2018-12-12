<?php
namespace app\forms;

use app\dto\Event;
use yii\base\Model;

/**
 * Class EventForm
 * @package app\forms
 */
class EventForm extends Model
{
    /**
     * @var int
     */
    public $idEvent;
    /**
     * @var int
     */
    public $idPointStatus;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idEvent', 'idPointStatus'], 'required']
        ];
    }

    /**
     * @param Event $event
     */
    public function fillThis($event)
    {
        $this->idEvent = $event->getId();
        $this->idPointStatus = $event->getPointStatus()->getId();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idPointStatus' => 'Статус события'
        ];
    }
}
