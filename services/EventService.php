<?php
namespace app\services;

use app\dto\Event;
use app\dto\EventGeneralReport;
use app\dto\EventOccupancySchedule;
use app\dto\EventRisk;
use app\dto\PointStatus;
use app\repositories\CustomerRepositoryInterface;
use app\repositories\DisinfectorRepositoryInterface;
use app\repositories\EventRepositoryInterface;
use app\repositories\PointRepositoryInterface;
use app\repositories\PointStatusRepositoryInterface;
use DateInterval;
use DateTime;
use Yii;

/**
 * Class EventService
 * @package app\services
 */
class EventService
{
    private $eventRepository;
    private $pointStatusRepository;
    private $pointRepository;
    private $customerRepository;
    private $disinfectorRepository;

    /**
     * EventService constructor.
     * @param EventRepositoryInterface $eventRepository
     * @param PointStatusRepositoryInterface $pointStatusRepository
     * @param PointRepositoryInterface $pointRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param DisinfectorRepositoryInterface $disinfectorRepository
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
        PointStatusRepositoryInterface $pointStatusRepository,
        PointRepositoryInterface $pointRepository,
        CustomerRepositoryInterface $customerRepository,
        DisinfectorRepositoryInterface $disinfectorRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->pointStatusRepository = $pointStatusRepository;
        $this->pointRepository = $pointRepository;
        $this->customerRepository = $customerRepository;
        $this->disinfectorRepository = $disinfectorRepository;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $idCustomer
     * @return array
     * @throws \Exception
     */
    public function getEventsStartFromTime($fromDate, $toDate, $idCustomer)
    {
        $toDate = new DateTime($toDate);
        $toDate = $toDate->add(DateInterval::createFromDateString('1 days'));
        $toTimestamp = $toDate->getTimestamp();
        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDate);

        $events = $this->eventRepository->getItemsByIdCustomerAndPeriod($idCustomer, $fromTimestamp, $toTimestamp);

        $preparedEvents = [];
        foreach ($events as &$event) {
            $created_at = $event->getCreatedAt()->format('d.m.Y');

            $url = '';
            if ($event->getPoint() !== null
                && $event->getPoint()->getFileCustomer() !== null
                && $event->getPoint()->getFileCustomer()->getId() !== null
            ) {
                $url = Yii::$app->urlManager->createAbsoluteUrl(['/']).
                    'account/show-scheme-point-control?id='.$event->getPoint()->getFileCustomer()->getId();
            }

            $nPoint = $event->getPoint() !== null && $event->getPoint()->getIdInternal() !== null
                ? $event->getPoint()->getIdInternal()
                : $event->getIdExternal();
            $fullName = $event->getDisinfector() !== null ? $event->getDisinfector()->getFullName() : '';
            $status = $event->getPointStatus() !== null ? $event->getPointStatus()->getDescription() : '';

            $preparedEvents [] = [
                'n_point'       => $nPoint,
                'full_name'     => $fullName,
                'date_check'    => $created_at,
                'status'        => $status,
                'url'           => $url
            ];
        }


        return $preparedEvents;
    }

    /**
     * @param $idCustomer
     * @param $dateFrom
     * @param $dateTo
     * @return mixed
     * @throws \Exception
     */
    public function getGreenRisk($idCustomer, $dateFrom, $dateTo)
    {
        $timestampFrom = $this->getTimestampFromDate($dateFrom);
        $timestampTo = $this->getTimestampFromDate($dateTo);

        $statuses = ['not_touch', 'part_replace'];
        /**
         * @var EventRisk[] $events
         */
        $events = $this->eventRepository->getEventsRisk($idCustomer, $timestampFrom, $timestampTo, $statuses);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $dateFrom
     * @param $dateTo
     * @return mixed
     * @throws \Exception
     */
    public function getRedRisk($idCustomer, $dateFrom, $dateTo)
    {
        $timestampFrom = $this->getTimestampFromDate($dateFrom);
        $timestampTo = $this->getTimestampFromDate($dateTo);
        
        $statuses = ['full_replace', 'caught'];
        /**
         * @var EventRisk[] $events
         */
        $events = $this->eventRepository->getEventsRisk($idCustomer, $timestampFrom, $timestampTo, $statuses);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        return $events;
    }

    /**
     * @param $idCustomer
     * @param $fromDate
     * @param $toDate
     * @return array
     * @throws \Exception
     */
    public function getOccupancyScheduleFromPeriod($idCustomer, $fromDate, $toDate)
    {
        $fromTimestamp = $this->getTimestampFromDate($fromDate);
        $toDate = new DateTime($toDate);
        $toDate = $toDate->add(DateInterval::createFromDateString('1 days'));
        $toTimestamp = $toDate->getTimestamp();

        /**
         * @var EventOccupancySchedule[] $events
         */
        $events = $this->eventRepository->getEventsOccupancySchedule($idCustomer, $fromTimestamp, $toTimestamp);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $label = 'График заселенности на выбранный период';

        return $this->preProcessingDataForGraphic($events, $label);
    }

    /**
     * @param $events
     * @param $label
     * @return array
     */
    public function preProcessingDataForGraphic($events, $label)
    {
        $datasets[0]['label'] = $label;
        $datasets[0]['data'] = [];
        $labels = [];
        foreach ($events as &$event) {
            switch ($event['month']) {
                case 1:
                    $event['month'] = 'Январь';
                    break;
                case 2:
                    $event['month'] = 'Февраль';
                    break;
                case 3:
                    $event['month'] = 'Март';
                    break;
                case 4:
                    $event['month'] = 'Апрель';
                    break;
                case 5:
                    $event['month'] = 'Май';
                    break;
                case 6:
                    $event['month'] = 'Июнь';
                    break;
                case 7:
                    $event['month'] = 'Июль';
                    break;
                case 8:
                    $event['month'] = 'Август';
                    break;
                case 9:
                    $event['month'] = 'Сентябрь';
                    break;
                case 10:
                    $event['month'] = 'Октябрь';
                    break;
                case 11:
                    $event['month'] = 'Ноябрь';
                    break;
                case 12:
                    $event['month'] = 'Декабрь';
                    break;
            }

            $datasets[0]['data'][] = $event['count'];
            $labels [] = $event['month'];
        }
        return [
            'labels'    => $labels,
            'datasets'  => $datasets
        ];
    }

    /**
     * @param $idCustomer
     * @return array
     */
    public function getGeneralReportCurrentMonth($idCustomer)
    {
        /**
         * @var EventGeneralReport[] $events
         */
        $events = $this->eventRepository->getEventsGeneralReport($idCustomer);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $events_free = 0;
        $events_caught = 0;
        foreach ($events as $item) {
            switch ($item['code']) {
                case 'part_replace':
                case 'not_touch':
                case 'full_replace':
                    $events_free++;
                    break;
                case 'caught':
                    $events_caught++;
                    break;
            }
        }

        $datasets[0] = [
            'label' => 'График заселенности за все время',
            'data'  => [$events_free, $events_caught],
            'backgroundColor'   => ["#3e95cd", "#8e5ea2"]
        ];
        return [
            'labels'    => ['Свободно', 'Заселено'],
            'datasets'  => $datasets
        ];
    }

    /**
     * @param $idCustomer
     * @param $from_datetime
     * @param $to_datetime
     * @return array
     * @throws \Exception
     */
    public function getPointReportFromPeriod($idCustomer, $from_datetime, $to_datetime)
    {
        $fromTimestamp = Yii::$app->formatter->asTimestamp($from_datetime);
        $to_datetime = new DateTime($to_datetime);
        $to_datetime = $to_datetime->add(DateInterval::createFromDateString('1 days'));
        $toTimestamp= $to_datetime->getTimestamp();

        /**
         * @var EventGeneralReport[] $events
         */
        $events = $this->eventRepository->getEventGeneralReportFromPeriod($idCustomer, $fromTimestamp, $toTimestamp);
        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $events_part_replace = 0;
        $events_not_touch = 0;
        $events_full_replace = 0;
        $events_caught = 0;
        $events_caught_insekt = 0;
        $events_caught_nagetier = 0;
        foreach ($events as $item) {
            switch ($item['code']) {
                case 'part_replace':
                    $events_part_replace++;
                    break;
                case 'not_touch':
                    $events_not_touch++;
                    break;
                case 'full_replace':
                    $events_full_replace++;
                    break;
                case 'caught':
                    $events_caught++;
                    break;
                case 'caught_insekt':
                    $events_caught_insekt++;
                    break;
                case 'caught_nagetier':
                    $events_caught_nagetier++;
                    break;
            }
        }
        $datasets[0] = [
            'label' => 'Отчет по точкам контроля за месяц',
            'data'  => [$events_not_touch, $events_part_replace, $events_full_replace,
                $events_caught, $events_caught_insekt, $events_caught_nagetier],
            'backgroundColor'   => ["yellow", "red", "green", "blue", "gray", "#894ea2"]
        ];

        /**
         * @var PointStatus[] $statuses
         */
        $statuses = $this->pointStatusRepository->all();

        $labels = [];

        foreach ($statuses as $status) {
            $labels [] = $status->getDescription();
        }

        return [
            'labels'    => $labels,
            'datasets'  => $datasets,
            'is_view'   => true
        ];
    }

    /**
     * @param $codeCompany
     * @param $idDisinfector
     * @param $idInternal
     * @param $idPointStatus
     */
    public function addEventFromOldAndroidApplication($codeCompany, $idDisinfector, $idInternal, $idPointStatus)
    {
        $customer = $this->customerRepository->getByByCode($codeCompany);

        $point = $this->pointRepository->getByIdInternal($idInternal, $customer->getId());

        $disinfector = $this->disinfectorRepository->get($idDisinfector);

        $pointStatus = $this->pointStatusRepository->get($idPointStatus);

        $event = (new Event())
            ->setCustomer($customer)
            ->setDisinfector($disinfector)
            ->setIdExternal($idInternal)
            ->setPoint($point)
            ->setPointStatus($pointStatus);

        $this->eventRepository->add($event);
    }

    /**
     * @param $idCustomer
     * @return array
     */
    public function getEventsForManager($idCustomer)
    {
        if ($idCustomer === null or empty($idCustomer)) {
            $events = $this->eventRepository->all();
        } else {
            $events = $this->eventRepository->getItemsByIdCustomer($idCustomer);
        }

        $preparedEvents = [];
        foreach ($events as $event) {
            $preparedEvents [] = [
                'id'            => $event->getId(),
                'name'          => $event->getCustomer()->getName(),
                'point_status'  => $event->getPointStatus()->getDescription(),
                'id_internal'   => $event->getPoint() !== null
                    ? $event->getPoint()->getIdInternal()
                    : null,
                'datetime'      => $event->getCreatedAt()->format('d.m.y h:i'),
                'count'         => $event->getCount()
            ];
        }

        return $preparedEvents;
    }

    /**
     * @param $id
     */
    public function deleteEvent($id)
    {
        $event = $this->eventRepository->get($id);
        $this->eventRepository->remove($event);
    }

    /**
     * @param $id
     * @return Event
     */
    public function getItemForEditing($id)
    {
        $event = $this->eventRepository->get($id);

        return $event;
    }

    /**
     * @param $id
     * @param $idPointStatus
     */
    public function saveItem($id, $idPointStatus)
    {
        $event = $this->eventRepository->get($id);
        $pointStatus = $this->pointStatusRepository->get($idPointStatus);
        $event->setPointStatus($pointStatus);

        $this->eventRepository->save($event);
    }

    /**
     * @param $idCustomer
     * @param $idDisinfector
     * @param $idExternal
     * @param $idStatus
     * @param $count
     */
    public function addEventFromNewAndroidApplication($idCustomer, $idDisinfector, $idExternal, $idStatus, $count)
    {
        $customer = $this->customerRepository->get($idCustomer);
        $point = $this->pointRepository->getByIdInternal($idExternal, $customer->getId());
        $disinfector = $this->disinfectorRepository->get($idDisinfector);
        $pointStatus = $this->pointStatusRepository->get($idStatus);

        $event = (new Event())
            ->setCustomer($customer)
            ->setPoint($point)
            ->setPointStatus($pointStatus)
            ->setDisinfector($disinfector)
            ->setCount($count);

        $this->eventRepository->add($event);
    }

    /**
     * @param $date
     * @return string
     * @throws \Exception
     */
    private function getTimestampFromDate($date)
    {
        $datetime = new DateTime($date);
        $timestamp = Yii::$app->formatter->asTimestamp($datetime);
        return $timestamp;
    }
}
