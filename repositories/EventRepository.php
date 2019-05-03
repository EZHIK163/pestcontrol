<?php
namespace app\repositories;

use app\dto\Customer;
use app\dto\Disinfector;
use app\dto\Event;
use app\dto\EventFileReport;
use app\dto\EventGeneralReport;
use app\dto\EventOccupancySchedule;
use app\dto\EventRisk;
use app\dto\EventSynchronize;
use app\dto\Point;
use app\dto\PointStatus;
use app\entities\EventRecord;
use app\exceptions\EventNotFound;
use DateTime;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\LazyLoadingInterface;
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
    private $lazyFactory;

    /**
     * EventRepository constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param DisinfectorRepositoryInterface $disinfectorRepository
     * @param PointRepositoryInterface $pointRepository
     * @param PointStatusRepositoryInterface $pointStatusRepository
     * @param LazyLoadingValueHolderFactory $lazyFactory
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        DisinfectorRepositoryInterface $disinfectorRepository,
        PointRepositoryInterface $pointRepository,
        PointStatusRepositoryInterface $pointStatusRepository,
        LazyLoadingValueHolderFactory $lazyFactory
    ) {
        $this->customerRepository = $customerRepository;
        $this->disinfectorRepository = $disinfectorRepository;
        $this->pointRepository = $pointRepository;
        $this->pointStatusRepository = $pointStatusRepository;
        $this->lazyFactory = $lazyFactory;
    }

    /**
     * @param $id
     * @throws EventNotFound
     * @return Event
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
     * @throws \Throwable
     * @return Event
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Event
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @return Event
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
    public function all($limit = 500)
    {
        $eventRecords = EventRecord::find()
            ->where(['is_active'    => true])
            ->limit($limit)
            ->orderBy('id DESC')
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
     * @throws EventNotFound
     * @return EventRecord
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
        if ($eventRecord->id_customer !== null) {
            /**
             * @var Customer $customer
             */
            $customer = $this->lazyFactory->createProxy(
                Customer::class,
                function (&$target, LazyLoadingInterface $proxy) use ($eventRecord) {
                    $target = $this->customerRepository->get($eventRecord->id_customer);
                    $proxy->setProxyInitializer(null);
                }
            );
        } else {
            $customer = null;
        }

        if ($eventRecord->id_disinfector !== null) {
            /**
             * @var Disinfector $disinfector
             */
            $disinfector = $this->lazyFactory->createProxy(
                Disinfector::class,
                function (&$target, LazyLoadingInterface $proxy) use ($eventRecord) {
                    $target = $this->disinfectorRepository->get($eventRecord->id_disinfector);
                    $proxy->setProxyInitializer(null);
                }
            );
        } else {
            $disinfector = null;
        }

        if ($eventRecord->id_point !== null) {
            /**
             * @var Point $point
             */
            $point = $this->lazyFactory->createProxy(
                Point::class,
                function (&$target, LazyLoadingInterface $proxy) use ($eventRecord) {
                    $target = $this->pointRepository->get($eventRecord->id_point);
                    $proxy->setProxyInitializer(null);
                }
            );
        } else {
            $point = null;
        }

        if ($eventRecord->id_point_status) {
            /**
             * @var PointStatus $pointStatus
             */
            $pointStatus = $this->lazyFactory->createProxy(
                PointStatus::class,
                function (&$target, LazyLoadingInterface $proxy) use ($eventRecord) {
                    $target = $this->pointStatusRepository->get($eventRecord->id_point_status);
                    $proxy->setProxyInitializer(null);
                }
            );
        } else {
            $pointStatus = null;
        }

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
            ->andWhere(['events.is_active' => true])
            ->andWhere(['points.is_active' => true])
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = $this->fillEvent($eventRecord);
        }

        return $events;
    }

    /**
     * @param $idPoint
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return Event[]
     */
    public function getItemsByIdPoint($idPoint, $fromTimestamp, $toTimestamp)
    {
        /**
         * @var EventRecord $eventRecords
         */
        $eventRecords = EventRecord::find()
            ->select('events.*')
            ->join('left join', 'public.points', 'points.id = events.id_point')
            ->where(['public.points.id'  => $idPoint])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->andWhere(['events.is_active' => true])
            ->andWhere(['points.is_active' => true])
            ->orderBy('events.created_at')
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

        $eventRecords = EventRecord::find()
            ->select('points.id_internal')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->join('inner join', 'public.points', 'events.id_point = points.id')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['>=', 'events.created_at', $fromTimestamp])
            ->andWhere(['<', 'events.created_at', $toTimestamp])
            ->andWhere($statusesForQuery)
            ->groupBy('points.id_internal')
            ->asArray()
            ->all();

        $events = [];
        foreach ($eventRecords as $eventRecord) {
            $events [] = (new EventRisk())->setIdExternal($eventRecord['id_internal']);
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @param $statuses
     * @return EventOccupancySchedule[]
     */
    public function getEventsOccupancySchedule($idCustomer, $fromTimestamp, $toTimestamp, $statuses)
    {
        $expressions = [];
        $expressions [] =
            new Expression("extract(month from to_timestamp(events.created_at)) as month, count(*) as count");
        $eventRecords = EventRecord::find()
            ->select($expressions)
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $idCustomer])
            ->andWhere(['in', 'point_status.code', $statuses])
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
     * @param int $limit
     * @return Event[]
     */
    public function getItemsByIdCustomer($idCustomer, $limit = 500)
    {
        $eventRecords = EventRecord::find()
            ->where(['is_active'        => true])
            ->andWhere(['id_customer'   => $idCustomer])
            ->orderBy('id ASC')
            ->limit($limit)
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
        $columns = '
        points.id_internal as id_external,
        point_status.code,
        events.created_at,
        events.count,
        file_customer.title';

        $eventRecords = EventRecord::find()
            ->select($columns)
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->join('inner join', 'public.points', 'points.id = events.id_point')
            ->join('inner join', 'public.file_customer', 'points.id_file_customer = file_customer.id')
            ->where(['file_customer.id_customer'  => $idCustomer])
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
                ->setStatusCode($eventRecord['code'])
                ->setTitleScheme($eventRecord['title']);
        }

        return $events;
    }

    /**
     * @param EventSynchronize[] $events
     * @throws \Throwable
     * @return void
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
