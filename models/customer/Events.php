<?php

namespace app\models\customer;

use ErrorException;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.events".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $id_customer
 * @property int $id_disinfector
 * @property int $id_external
 * @property int $id_point
 * @property int $id_point_status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $count
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_customer', 'id_disinfector', 'id_external', 'id_point_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_customer', 'id_disinfector', 'id_external', 'id_point_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['id_customer' => 'id']],
            [['id_disinfector'], 'exist', 'skipOnError' => true, 'targetClass' => Disinfector::class, 'targetAttribute' => ['id_disinfector' => 'id']],
            [['id_point_status'], 'exist', 'skipOnError' => true, 'targetClass' => PointStatus::class, 'targetAttribute' => ['id_point_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_active' => 'Is Active',
            'id_customer' => 'Id Customer',
            'id_disinfector' => 'Id Disinfector',
            'id_external' => 'Id External',
            'id_point_status' => 'Id Point Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }

    public static function getEventsFromPeriod($id_customer, $from_datetime, $to_datetime) {

        $to_datetime = new \DateTime($to_datetime);
        $to_datetime = $to_datetime->add(\DateInterval::createFromDateString('1 days'));
        $end_timestamp= $to_datetime->getTimestamp();
        $start_timestamp = \Yii::$app->formatter->asTimestamp($from_datetime);
        //$end_timestamp = \Yii::$app->formatter->asTimestamp($to_datetime);

        return self::getEventsStartFromTime($start_timestamp, $end_timestamp, $id_customer);
    }

    public static function getEventsStartFromTime($start_timestamp, $end_timestamp, $id_customer) {
        $events = self::find()
            ->select('disinfectors.full_name, point_status.description as status, events.created_at, points.id_internal, events.id_external, points.id_file_customer')
            ->join('inner join', 'public.disinfectors', 'disinfectors.id = events.id_disinfector')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->join('left join', 'public.points', 'points.id = events.id_point')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $start_timestamp])
            ->andWhere(['<', 'events.created_at', $end_timestamp])
            ->asArray()
            ->all();

        $finish_events = [];
        foreach ($events as &$event) {
            $created_at = ((new \DateTime(date('Y-m-d H:i:s', $event['created_at'] )))
                ->format('d.m.Y'));
            $url = '';
            if (!is_null($event['id_file_customer'])) {
                $url = \Yii::$app->urlManager->createAbsoluteUrl(['/']). 'account/show-scheme-point-control?id='.$event['id_file_customer'];
            }
            $finish_events [] = [
                'n_point'       => !is_null($event['id_internal']) ? $event['id_internal'] : $event['id_external'],
                'full_name'     => $event['full_name'],
                'date_check'    => $created_at,
                'status'        => $event['status'],
                'url'           => $url
            ];
        }


        return $finish_events;
    }

    public static function getGreenRisk($id_customer, $date_from, $date_to) {

        if (!is_null($date_from) && !is_null($date_to)) {
            $datetime_from = new \DateTime($date_from);
            $datetime_to = new \DateTime($date_to);

            $timestamp_from = \Yii::$app->formatter->asTimestamp($datetime_from);
            $timestamp_to = \Yii::$app->formatter->asTimestamp($datetime_to);
        } else {
            $datetime_from = new \DateTime();
            $datetime_from = $datetime_from->sub(\DateInterval::createFromDateString('1 month'));
            $datetime_to = new \DateTime();

            $timestamp_from = \Yii::$app->formatter->asTimestamp($datetime_from);
            $timestamp_to = \Yii::$app->formatter->asTimestamp($datetime_to);
        }

        $events = self::find()
            ->select('events.id_external')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $timestamp_from])
            ->andWhere(['<', 'events.created_at', $timestamp_to])
            ->andWhere(['or',
                ['point_status.code'  => 'not_touch'],
                ['point_status.code'  => 'part_replace']
            ])
            ->groupBy('events.id_external')
            ->asArray()
            ->all();
        return $events;
    }

    public static function getRedRisk($id_customer, $date_from, $date_to) {

        if (!is_null($date_from) && !is_null($date_to)) {
            $datetime_from = new \DateTime($date_from);
            $datetime_to = new \DateTime($date_to);

            $timestamp_from = \Yii::$app->formatter->asTimestamp($datetime_from);
            $timestamp_to = \Yii::$app->formatter->asTimestamp($datetime_to);
        } else {
            $datetime_from = new \DateTime();
            $datetime_from = $datetime_from->sub(\DateInterval::createFromDateString('1 month'));
            $datetime_to = new \DateTime();

            $timestamp_from = \Yii::$app->formatter->asTimestamp($datetime_from);
            $timestamp_to = \Yii::$app->formatter->asTimestamp($datetime_to);
        }

        $events = self::find()
            ->select('events.id_external')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->andWhere(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $timestamp_from])
            ->andWhere(['<', 'events.created_at', $timestamp_to])
            ->andWhere(['or',
                ['point_status.code'  => 'full_replace'],
                ['point_status.code'  => 'caught']
            ])
            ->groupBy('events.id_external')
            ->asArray()
            ->all();
        return $events;
    }


    public static function getOccupancyScheduleFromPeriod($id_customer, $from_datetime, $to_datetime) {

        $start_timestamp = \Yii::$app->formatter->asTimestamp($from_datetime);
        $to_datetime = new \DateTime($to_datetime);
        $to_datetime = $to_datetime->add(\DateInterval::createFromDateString('1 days'));
        $end_timestamp= $to_datetime->getTimestamp();

        $events = self::getEventsForOccupancyFromAndToTime($id_customer, $start_timestamp, $end_timestamp) ;
        $label = 'График заселенности на выбранный период';

        return self::preProcessingDataForGraphic($events, $label);
    }

    public static function getEventsForOccupancyFromAndToTime($id_customer, $from_time, $end_time) {
        $expressions = [];
        $expressions [] = new Expression("extract(month from to_timestamp(events.created_at)) as month, count(*) as count");
        $events = self::find()
            ->select($expressions)
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['point_status.code'  => 'caught'])
            ->andWhere(['>=', 'events.created_at', $from_time])
            ->andWhere(['<', 'events.created_at', $end_time])
            ->groupBy('extract(month from to_timestamp(events.created_at))')
            ->asArray()
            ->all();

        return $events;
    }


    public static function preProcessingDataForGraphic($events, $label) {
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

    public static function getGeneralReportCurrentMonth($id_customer) {
        $events = self::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->asArray()
            ->all();

        $events_free = 0;
        $events_caught = 0;
        foreach ($events as $item) {
            switch($item['code']) {
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

    public static function getPointReportFromPeriod($id_customer, $from_datetime, $to_datetime) {

        $start_timestamp = \Yii::$app->formatter->asTimestamp($from_datetime);
        $to_datetime = new \DateTime($to_datetime);
        $to_datetime = $to_datetime->add(\DateInterval::createFromDateString('1 days'));
        $end_timestamp= $to_datetime->getTimestamp();

        $events = self::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $start_timestamp])
            ->andWhere(['<', 'events.created_at', $end_timestamp])
            ->asArray()
            ->all();

        $events_part_replace = 0;
        $events_not_touch = 0;
        $events_full_replace = 0;
        $events_caught = 0;
        $events_caught_insekt = 0;
        $events_caught_nagetier = 0;
        foreach ($events as $item) {
            switch($item['code']) {
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
            'data'  => [$events_not_touch, $events_part_replace, $events_full_replace, $events_caught, $events_caught_insekt, $events_caught_nagetier],
            'backgroundColor'   => ["yellow", "red", "green", "blue", "gray", "#894ea2"]
        ];

        $statuses = PointStatus::getStatusesForApplication();

        $labels = [];

        foreach ($statuses as $status) {
            $labels [] = $status['description'];
        }

        return [
            'labels'    => $labels,
            'datasets'  => $datasets,
            'is_view'   => true
        ];
    }

    public static function getPointReportAllPeriod($id_customer) {

        $events = self::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->asArray()
            ->all();

        $events_part_replace = 0;
        $events_not_touch = 0;
        $events_full_replace = 0;
        $events_caught = 0;
        foreach ($events as $item) {
            switch($item['code']) {
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
            }
        }
        $datasets[0] = [
            'label' => 'Отчет по точкам контроля за все время',
            'data'  => [$events_not_touch, $events_part_replace, $events_full_replace, $events_caught],
            'backgroundColor'   => ["#3e95cd", "#3463a2", "#894ea2", "green"]
        ];
        return [
            'labels'    => ["Приманка не тронута", "Частичная замена приманки", "Полная замена приманки", "Пойман вредитель"],
            'datasets'  => $datasets
        ];
    }

    static function getDataForReport($id_customer) {

        $from_datetime = (new \DateTime())->format('01.01.Y');
        $start_timestamp = \Yii::$app->formatter->asTimestamp($from_datetime);

        $events = self::find()
            ->select('events.id_external, point_status.code, events.created_at, events.count')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(compact('id_customer'))
            ->andWhere(['>=', 'events.created_at', $start_timestamp])
            ->orderBy('events.created_at ASC')
        ->asArray()
        ->all();

        $data = [];
        foreach ($events as $item) {
            $data[$item['id_external']] [] = $item;
        }

        ksort($data);

        $result = [];
        foreach ($data as $id_external => $point) {
            foreach ($point as $item) {
                $month = date('m', $item['created_at']);
                $result[$id_external][$month] [] = $item;
            }
        }

        $data = [];
        foreach ($result as $id_external => $months) {
            foreach ($months as $my_month => $month) {
                $statistics = [];
                foreach ($month as $event) {
                    switch($event['code']) {
                        case 'part_replace':
                            $statistics [] = '1';
                            break;
                        case 'not_touch':
                            $statistics [] = '0';
                            break;
                        case 'full_replace':
                            $statistics [] = '2';
                            break;
                        case 'caught':
                            $statistics [] = '3';
                            break;
                        case 'caught_insekt':
                            $statistics [] = '3Н'.$event['count'];
                            break;
                        case 'caught_nagetier':
                            $statistics [] = '3Г'.$event['count'];
                            break;
                    }
                }
                $data[$id_external][$my_month] = implode(' | ', $statistics);

            }
            $data[$id_external]['name'] = '';
        }

        return $data;
    }

    static function addEvent($code_company, $id_disinfector, $id_external, $id_point_status) {

        $id_customer = Customer::getIdCustomerByCode($code_company);

        $id_point = Points::getPointByIdInternal($id_external, $id_customer);
        $event = new Events();

        $event->id_customer = $id_customer;
        $event->id_disinfector = $id_disinfector;
        $event->id_external = $id_external;
        $event->id_point = $id_point;
        $event->id_point_status = $id_point_status;

        $event->save();
    }

    static function getEventsForManager($id_customer) {

        $events = self::find()
            ->select('events.id, customers.name, point_status.description as point_status, points.id_internal, events.created_at')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->join('inner join', 'public.points', 'points.id = events.id_point')
            ->join('inner join', 'public.customers', 'customers.id = events.id_customer')
            ->andWhere(['events.is_active' => true]);


        if (!is_null($id_customer)) {
            $events = $events->andWhere(['events.id_customer'    => $id_customer]);
        }

        $events = $events
            ->orderBy('events.id ASC')
            ->asArray()
            ->all();

        foreach ($events as &$event) {
            $event['datetime'] = date('d.m.y h:i', $event['created_at']);
        }

        return $events;
    }

    static function deleteEvent($id) {
        $event = self::findOne($id);
        $event->is_active = false;

        $event->save();
    }

    static function getItemForEditing($id) {
        $event = self::find()
            ->select('id_point_status')
            ->where(['id'  => $id])
            ->asArray()
            ->all();

        if (!isset($event[0])) {
            throw new ErrorException("Точка не найдена");
        }
        return $event[0];
    }

    static function saveItem($id, $id_point_status) {
        $event = self::findOne($id);
        $event->id_point_status = $id_point_status;
        $event->save();
    }

    static function addEvent2($id_customer, $id_desinector, $id_external, $id_status, $count) {

        $id_point = Points::getPointByIdInternal($id_external, $id_customer);
        $event = new Events();

        $event->id_customer = $id_customer;
        $event->id_disinfector = $id_desinector;
        $event->id_external = $id_external;
        $event->id_point = $id_point;
        $event->id_point_status = $id_status;
        $event->count = $count;

        $event->save();
    }
}
