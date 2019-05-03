<?php
namespace app\services;

use app\repositories\EventRepositoryInterface;
use DateTime;
use Yii;

/**
 * Class ReportService
 * @package app\services
 */
class ReportService
{
    private $disinfectantService;
    private $eventRepository;

    /**
     * ReportService constructor.
     * @param DisinfectantService $disinfectantService
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(DisinfectantService $disinfectantService, EventRepositoryInterface $eventRepository)
    {
        $this->disinfectantService = $disinfectantService;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param $idCustomer
     * @return array
     */
    public function getDataFromPeriod($fromDate, $toDate, $idCustomer)
    {
        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDate);
        $toTimestamp = Yii::$app->formatter->asTimestamp($toDate);

        $disinfectants = $this->disinfectantService->getDisinfectants();

        $events = $this->eventRepository->getEventGeneralReportFromPeriod($idCustomer, $fromTimestamp, $toTimestamp);
        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $events_part_replace = 0;
        $events_not_touch = 0;
        $events_full_replace = 0;
        $events_caught = 0;
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
                case 'caught_insekt':
                case 'caught_nagetier':
                //case 'caught':
                    $events_caught++;

                    break;
            }
        }
        $data = [];
        $setting_column = [];
        foreach ($disinfectants as &$disinfectant) {
            switch ($disinfectant['code']) {
                case 'alt-klej':
                    $data[0][$disinfectant['code']] = $events_caught * floatval($disinfectant['value']);
                    //$disinfectant['count'] =
                    break;
                case 'shturm_brickety':
                    $data[0][$disinfectant['code']] = ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;

                    break;
                case 'shturm_granuly':
                    $data[0][$disinfectant['code']] = ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;

                    break;
                case 'indan-block':
                    $data[0][$disinfectant['code']] = ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;

                    break;
                case 'rattidion':
                    $data[0][$disinfectant['code']] = ($events_full_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;

                    break;
            }

            $setting_column [] = [
                'attribute' => $disinfectant['code'],
                'header'    => $disinfectant['description']
            ];
        }

        $data['setting_column'] = $setting_column;

        return $data;
    }

    /**
     * @param $id_customer
     * @param $from_datetime
     * @param $to_datetime
     * @return array
     */
    public function getDataForFileReport($id_customer, $from_datetime, $to_datetime)
    {
        $data = $this->getDataFromPeriod($from_datetime, $to_datetime, $id_customer);
        unset($data['setting_column']);

        $result = [];
        foreach ($data[0] as $key => $item) {
            $disinfectant = $this->disinfectantService->getDisinfectantByCode($key);
            $result [] = [
                'value'                         => $item,
                'name'                          => $disinfectant->getDescription(),
                'form_of_facility'              => $disinfectant->getFormOfFacility(),
                'active_substance'              => $disinfectant->getActiveSubstance(),
                'concentration_of_substance'    => $disinfectant->getConcentrationOfSubstance(),
                'manufacturer'                  => $disinfectant->getManufacturer(),
                'terms_of_use'                  => $disinfectant->getTermsOfUse(),
                'place_of_application'          => $disinfectant->getPlaceOfApplication(),
                'disinfector'                   => ''
            ];
        }

        return $result;
    }

    /**
     * @param $idCustomer
     * @throws \Exception
     * @return array
     */
//    public function getDataForReport($idCustomer)
//    {
//        $fromDatetime = (new DateTime())->format('01.01.Y');
//        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDatetime);
//
//        $events = $this->eventRepository->getEventFileReport($idCustomer, $fromTimestamp);
//
//        foreach ($events as &$event) {
//            $event = $event->toArray();
//        }
//
//        $data = [];
//        foreach ($events as $item) {
//            $data[$item['id_external']] [] = $item;
//        }
//
//        ksort($data);
//
//        $result = [];
//        foreach ($data as $id_external => $point) {
//            foreach ($point as $item) {
//                $month = $item['created_at'];
//                $result[$id_external][$month] [] = $item;
//            }
//        }
//
//        $data = [];
//        foreach ($result as $id_external => $months) {
//            foreach ($months as $my_month => $month) {
//                $statistics = [];
//                foreach ($month as $event) {
//                    switch ($event['code']) {
//                        case 'part_replace':
//                            $statistics [] = '1';
//                            break;
//                        case 'not_touch':
//                            $statistics [] = '0';
//                            break;
//                        case 'full_replace':
//                            $statistics [] = '2';
//                            break;
//                        case 'caught':
//                            $statistics [] = '3';
//                            break;
//                        case 'caught_insekt':
//                            $statistics [] = '3Н'.$event['count'];
//                            break;
//                        case 'caught_nagetier':
//                            $statistics [] = '3Г'.$event['count'];
//                            break;
//                    }
//                }
//                $data[$id_external][$my_month] = implode(' | ', $statistics);
//            }
//            $data[$id_external]['name'] = '';
//        }
//
//        return $data;
//    }

    public function getDataForReportNew($idCustomer)
    {
        $fromDatetime = (new DateTime())->format('01.01.Y');
        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDatetime);

        $events = $this->eventRepository->getEventFileReport($idCustomer, $fromTimestamp);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $data = [];
        foreach ($events as $item) {
            $data[$item['id_external']] [] = $item;
        }

        ksort($data);

        $result = [];
        foreach ($data as $id_external => $point) {
            foreach ($point as $item) {
                $month = $item['created_at'];
                $result[$id_external][$month] [] = $item;
            }
        }

        $data = [];
        foreach ($result as $id_external => $months) {
            foreach ($months as $my_month => $month) {
                $statistics = [];
                foreach ($month as $event) {
                    switch ($event['code']) {
                        case 'part_replace':
                            $statistics [] = '1';

                            break;
                        case 'not_touch':
                            $statistics [] = '0';

                            break;
                        case 'full_replace':
                            $statistics [] = '2';

                            break;
                        //case 'caught':
                        //    $statistics [] = '3';
                        //    break;
                        case 'caught_insekt':
                            $statistics [] = 'Н' . $event['count'];

                            break;
                        case 'caught_nagetier':
                            $statistics [] = 'Г' . $event['count'];

                            break;
                    }
                }
                $data[$id_external][$my_month] = implode(' | ', $statistics);
            }
            $data[$id_external]['name'] = '';
        }

        return $data;
    }

    /**
     * @param $idCustomer
     * @throws \Exception
     * @return array
     */
    public function getDataForReportHeineken($idCustomer)
    {
        $fromDatetime = (new DateTime())->format('01.m.Y');
        $fromTimestamp = Yii::$app->formatter->asTimestamp($fromDatetime);

        $events = $this->eventRepository->getEventFileReport($idCustomer, $fromTimestamp);

        foreach ($events as &$event) {
            $event = $event->toArray();
        }

        $groupByScheme = [];
        foreach ($events as $event) {
            $groupByScheme[$event['title_scheme']] [] = $event;
        }

        $data = [];
        foreach ($groupByScheme as $name => $scheme) {
            $points = [];
            $countCriticalPoints = 0;
            foreach ($scheme as $event) {
                switch ($event['code']) {
                    case 'caught':
                    case 'caught_nagetier':
                    case 'caught_insekt':
                        $countCriticalPoints++;

                        break;
                }
                $points [] = $event['id_external'];
            }

            sort($points);

            $index = 0;
            $points = array_unique($points, SORT_NUMERIC);
            $points = $this->unionPoints($points);

            $data[$name] = [
                'title'                 => $name,
                'points'                => $points,
                'count_critical_points' => $countCriticalPoints,
                'index'                 => $index
            ];
        }

        return $data;
    }

    /**
     * @param $points
     * @return string
     */
    private function unionPoints($points)
    {
        $simplePoints = [];
        foreach ($points as $point) {
            $simplePoints [] = $point;
        }

        $unionPoints = [];
        $j = 0;
        $unionPoints[$j] [] = $points[0];
        for ($i = 1; $i <= count($simplePoints); $i = $i + 1) {
            if ((int)$simplePoints[$i - 1] + 1 === (int)$simplePoints[$i]) {
                $unionPoints[$j][] = (int)$simplePoints[$i];
            } else {
                $j++;
            }
        }

        $set = [];
        foreach ($unionPoints as $unionPoint) {
            if (count($unionPoint) > 1) {
                $set [] = reset($unionPoint) . ' - ' . end($unionPoint);
            } else {
                $set [] = reset($unionPoint);
            }
        }

        return implode(', ', $set);
    }
}
