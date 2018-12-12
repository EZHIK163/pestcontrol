<?php
namespace app\models\customer;

use app\dto\Event;
use app\services\EventService;
use yii\base\Model;

class ManageEventForm extends Model
{
    public $id_event;
    public $id_point_status;

    private $eventService;

    public function rules()
    {
        return [
            [['id_event', 'id_point_status'], 'required']
        ];
    }

    /**
     * ManageEventForm constructor.
     * @param EventService $eventService
     * @param array $config
     */
    public function __construct(EventService $eventService, array $config = [])
    {
        $this->eventService = $eventService;
        parent::__construct($config);
    }

    /**
     * @param Event $event
     */
    public function fillThis($event)
    {
        $this->id_event = $event->getId();
        $this->id_point_status = $event->getPointStatus()->getId();
    }

    public function attributeLabels()
    {
        return [
            'id_point_status' => 'Статус события'
        ];
    }
}
