<?php
namespace app\repositories;

use app\dto\Event;
use app\dto\EventFileReport;
use app\dto\EventGeneralReport;
use app\dto\EventOccupancySchedule;
use app\dto\EventRisk;
use app\dto\EventSynchronize;
use app\entities\EventRecord;
use app\exceptions\EventNotFound;
use DateTime;
use RuntimeException;
use yii\db\Expression;

/**
 * Class EventRepository
 * @package app\repositories
 */
class EventRepository implements EventRepositoryInterface
{
    private $customerRepository;
    private $disinfectorRepository;
    private $pointRepository;
    private $pointStatusRepository;

    /**
     * EventRepository constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param DisinfectorRepositoryInterface $disinfectorRepository
     * @param PointRepositoryInterface $pointRepository
     * @param PointStatusRepositoryInterface $pointStatusRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        DisinfectorRepositoryInterface $disinfectorRepository,
        PointRepositoryInterface $pointRepository,
        PointStatusRepositoryInterface $pointStatusRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->disinfectorRepository = $disinfectorRepository;
        $this->pointRepository = $pointRepository;
        $this->pointStatusRepository = $pointStatusRepository;
    }

    /**
     * @param $id
     * @return Event
     * @throws EventNotFound
     */
    public function get($id)
    {
        /**
         * @var EventRecord $eventRecord
         */
        $eventRecord = $this->findOrFail($id);

        $event = $this->fillEvent($eventRecord);

        return $event;
    }

    /**
     * @param Event $event
     * @return Event
     * @throws \Throwable
     */
    public function add(Event $event)
    {
        $eventRecord = new EventRecord();

        $eventRecord = $this->fillEventRecord($eventRecord, $event);

        if (!$eventRecord->insert()) {
            throw new RuntimeException();
        }

        $event->setId($eventRecord->id);

        return $event;
    }

    /**
     * @param Event $event
     * @return Event
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Event $event)
    {
        /**
         * @var EventRecord $eventRecord
         */
        $eventRecord = $this->findOrFail($event->getId());

        $eventRecord = $this->fillEventRecord($eventRecord, $event);

        $eventRecord->update();

        return $event;
    }

    /**
     * @param Event $event
     * @return Event
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Event $event)
    {
        $eventRecord = $this->findOrFail($event->getId());

        $eventRecord->is_active = false;

        if (!$eventRecord->update()) {
            throw new \RuntimeException();
        }

        $event->setIsActive(false);

        return $event;
    }

    /**
     * @param int $limit
     * @return Event[]
     */
    public function all($limit = 100)
    {
        $eventRecords = EventRecord::find()
            ->where(['is_active'    => true])
            ->limit($limit)
            ->orderBy('id ASC')
            ->all();

        $events = [];
        /**
         * @var EventRecord $eventRecord
         */
        foreach ($eventRecords as $eventRecord) {
            $events [] = $this->fillEvent($eventRecord);
        }

        return $events;
    }

    /**
     * @param $id
     * @return EventRecord
     * @throws EventNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var EventRecord $event
         */
        if (!($event = EventRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new EventNotFound();
        }

        return $event;
    }

    /**
     * @param EventRecord $eventRecord
     * @return Event
     */
    private function fillEvent($eventRecord)
    {
        $customer = $eventRecord->id_customer !== null
            ? $this->customerRepository->get($eventRecord->id_customer)
            : null;
        $disinfector = $eventRecord->id_disinfector !== null
            ? $this->disinfectorRepository->get($eventRecord->id_disinfector)
            : null;
        $point = $eventRecord->id_point !== null
            ? $this->pointRepository->get($eventRecord->id_point)
            : null;

        $pointStatus = $eventRecord->id_point_status !== null
            ? $this->pointStatusRepository->get($eventRecord->id_point_status)
            : null;

        $event = (new Event())
            ->setId($eventRecord->id)
            ->setCount($eventRecord->count)
            ->setCustomer($customer)
            ->setDisinfector($disinfector)
            ->setIdExternal($eventRecord->id_external)
            ->setPoint($point)
            ->setPointStatus($pointStatus)
            ->setCreatedAt(DateTime::createFromFormat('U', (string)$eventRecord->created_at));

        return $event;
    }

    /**
     * @param EventRecord $eventRecord
     * @param Event $event
     * @return EventRecord
     */
    private function fillEventRecord($eventRecord, $event)
    {
        $eventRecord->count = $event->getCount();
        $eventRecord->id_customer = $event->getCustomer()->getId();
        $eventRecord->id_disinfector = $event->getDisinfector()->getId();
        $eventRecord->id_external = $event->getIdExternal();
        $eventRecord->id_point = $event->getPoint() !== null
            ? $event->getPoint()->getId()
            : null;
        $eventRecord->id_point_status = $event->getPointStatus()->getId();

        return $eventRecord;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return Event[]
     */
    public function getItemsByIdCustomerAndPeriod($idCustomer, $fromTimestamp, $toTimestamp)
    {
        /**
         * @var EventRecord $eventRecords
         */
        $eventRecords = EventRecord::find()
            ->select('events.*')
            ->join('left join', 'public.points', 'points.id = events.id_point')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = $this->fillEvent($eventRecord);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @param $statuses
     * @return EventRisk[]
     */
    public function getEventsRisk($idCustomer, $fromTimestamp, $toTimestamp, $statuses)
    {
        $statusesForQuery = ['or'];
        foreach ($statuses as $status) {
            $statusesForQuery [] = ['point_status.code'  => $status];
        }

        /**
         * @var EventRecord $eventRecords
         */
        $eventRecords = EventRecord::find()
            ->select('events.id_external')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->andWhere($statusesForQuery)
            ->groupBy('events.id_external')
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventRisk())->setIdExternal($eventRecord->id_external);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return EventOccupancySchedule[]
     */
    public function getEventsOccupancySchedule($idCustomer, $fromTimestamp, $toTimestamp)
    {
        $expressions = [];
        $expressions [] = new Expression("extract(month from to_timestamp(events.created_at)) as month, count(*) as count");
        $eventRecords = EventRecord::find()
            ->select($expressions)
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['point_status.code'  => 'caught'])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->groupBy('extract(month from to_timestamp(events.created_at))')
            ->asArray()
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventOccupancySchedule())
                ->setMonth($eventRecord['month'])
                ->setCount($eventRecord['count']);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @return EventGeneralReport[]
     */
    public function getEventsGeneralReport($idCustomer)
    {
        $eventRecords = EventRecord::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $idCustomer])
            ->asArray()
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventGeneralReport())->setStatusCode($eventRecord['code']);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return EventGeneralReport[]
     */
    public function getEventGeneralReportFromPeriod($idCustomer, $fromTimestamp, $toTimestamp)
    {
        $eventRecords = EventRecord::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->asArray()
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventGeneralReport())->setStatusCode($eventRecord['code']);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @return Event[]
     */
    public function getItemsByIdCustomer($idCustomer)
    {
        $eventRecords = EventRecord::find()
            ->where(['is_active'        => true])
            ->andWhere(['id_customer'   => $idCustomer])
            ->orderBy('id ASC')
            ->all();

        $events = [];
        /**
         * @var EventRecord $eventRecord
         */
        foreach ($eventRecords as $eventRecord) {
            $events [] = $this->fillEvent($eventRecord);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @return EventFileReport[]
     */
    public function getEventFileReport($idCustomer, $fromTimestamp)
    {
        $eventRecords = EventRecord::find()
            ->select('events.id_external, point_status.code, events.created_at, events.count')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['id_customer'  => $idCustomer])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->orderBy('events.created_at ASC')
            ->asArray()
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventFileReport())
                ->setCreatedAt(DateTime::createFromFormat('U', (string)$eventRecord['created_at']))
                ->setCount($eventRecord['count'])
                ->setIdExternal($eventRecord['id_external'])
                ->setStatusCode($eventRecord['code']);
        }

        return $events;
    }

    /**
     * @param EventSynchronize[] $events
     * @return void
     * @throws \Throwable
     */
    public function addEventFromOldDb($events)
    {
        foreach ($events as $event) {
            $eventRecord = new EventRecord();

            $eventRecord->id_disinfector = $event->getIdDisinfector();
            $eventRecord->id_customer = $event->getIdCustomer();
            $eventRecord->id_external = $event->getIdExternal();
            $eventRecord->id_point_status = $event->getIdPointStatus();
            $eventRecord->created_at = $event->getCreatedAt();
            $eventRecord->created_by = $event->getCreatedBy();
            $eventRecord->updated_at = $event->getUpdatedAt();
            $eventRecord->updated_by = $event->getUpdatedBy();

            $eventRecord->insert();
        }
    }
}
