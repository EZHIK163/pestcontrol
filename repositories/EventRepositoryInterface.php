<?php
namespace app\repositories;

use app\dto\Event;
use app\dto\EventFileReport;
use app\dto\EventGeneralReport;
use app\dto\EventSynchronize;

/**
 * Interface EventRepositoryInterface
 * @package app\repositories
 */
interface EventRepositoryInterface
{
    /**
     * @param $id
     * @return Event
     */
    public function get($id);

    /**
     * @param Event $event
     * @return Event
     */
    public function add(Event $event);

    /**
     * @param Event $event
     * @return Event
     */
    public function save(Event $event);

    /**
     * @param Event $event
     * @return Event
     */
    public function remove(Event $event);

    /**
     * @return Event[]
     */
    public function all();

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return Event[]
     */
    public function getItemsByIdCustomerAndPeriod($idCustomer, $fromTimestamp, $toTimestamp);

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @param $statuses
     * @return Event[]
     */
    public function getEventsRisk($idCustomer, $fromTimestamp, $toTimestamp, $statuses);

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return EventReport[]
     */
    public function getEventsOccupancySchedule($idCustomer, $fromTimestamp, $toTimestamp);

    /**
     * @param $idCustomer
     * @return EventGeneralReport[]
     */
    public function getEventsGeneralReport($idCustomer);

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @param $toTimestamp
     * @return EventGeneralReport[]
     */
    public function getEventGeneralReportFromPeriod($idCustomer, $fromTimestamp, $toTimestamp);

    /**
     * @param $idCustomer
     * @return Event[]
     */
    public function getItemsByIdCustomer($idCustomer);

    /**
     * @param $idCustomer
     * @param $fromTimestamp
     * @return EventFileReport[]
     */
    public function getEventFileReport($idCustomer, $fromTimestamp);

    /**
     * @param EventSynchronize[] $events
     * @return void
     */
    public function addEventFromOldDb($events);
}
