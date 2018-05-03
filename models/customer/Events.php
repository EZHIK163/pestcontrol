<?php

namespace app\models\customer;

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
 * @property int $id_point_status
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
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
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['id_customer' => 'id']],
            [['id_disinfector'], 'exist', 'skipOnError' => true, 'targetClass' => Disinfectors::class, 'targetAttribute' => ['id_disinfector' => 'id']],
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

    public static function getEventsCurrentMonth($id_customer) {
        $start_current_month = date('Y-m-01');
        $start_current_month = \Yii::$app->formatter->asTimestamp($start_current_month);

        return self::getEventsStartFromTime($start_current_month, $id_customer);
    }

    public static function getEventsCurrentYear($id_customer) {
        $start_current_year = date('Y-01-01');
        $start_current_year = \Yii::$app->formatter->asTimestamp($start_current_year);

        return self::getEventsStartFromTime($start_current_year, $id_customer);
    }

    public static function getEventsStartFromTime($start_current_month, $id_customer) {
        $events = self::find()
            ->select('disinfectors.full_name, point_status.description as status, events.created_at')
            ->join('inner join', 'public.disinfectors', 'disinfectors.id = events.id_disinfector')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $start_current_month])
            ->limit(500)
            ->asArray()
            ->all();

        $finish_events = [];
        foreach ($events as &$event) {
            $created_at = ((new \DateTime(date('Y-m-d H:i:s', $event['created_at'] )))
                ->format('d.m.Y'));
            $finish_events [] = [
                'full_name'     => $event['full_name'],
                'date_check'    => $created_at,
                'status'        => $event['status']
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


    public static function getOccupancyScheduleCurrentYear($id_customer) {

        $start_current_year = date('Y-01-01');
        $from_time = \Yii::$app->formatter->asTimestamp($start_current_year);
        $events = self::getEventsForOccupancyFromAndToTime($id_customer, $from_time) ;
        $label = 'График заселенности на текущий год';

        return self::preProcessingDataForGraphic($events, $label);
    }

    public static function getEventsForOccupancyFromAndToTime($id_customer, $from_time, $end_time = null) {
        $expressions = [];
        $expressions [] = new Expression("extract(month from to_timestamp(events.created_at)) as month, count(*) as count");
        $events = self::find()
            ->select($expressions)
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['point_status.code'  => 'caught']);
        if (!is_null($end_time)) {
            $events = $events
                ->andWhere(['>=', 'events.created_at', $from_time])
                ->andWhere(['<', 'events.created_at', $end_time])
                ->groupBy('extract(month from to_timestamp(events.created_at))')
                ->asArray()
                ->all();
        } else {
            $events = $events->andWhere(['>=', 'events.created_at', $from_time])
                ->groupBy('extract(month from to_timestamp(events.created_at))')
                ->asArray()
                ->all();
        }


        return $events;
    }

    public static function getOccupancySchedulePreviousYear($id_customer) {

        $start_current_year = date('Y-01-01');
        $datetime_current_year = new \DateTime($start_current_year);
        $end_time = \Yii::$app->formatter->asTimestamp($start_current_year);
        $from_time = $datetime_current_year->sub(\DateInterval::createFromDateString('1 year'));

        $label = 'График заселенности за '.$from_time->format('Y').' год';

        $from_time = \Yii::$app->formatter->asTimestamp($from_time);

        $events = self::getEventsForOccupancyFromAndToTime($id_customer, $from_time, $end_time);



        return self::preProcessingDataForGraphic($events, $label);
    }

    public static function getOccupancySchedulePreviousPreviousYear($id_customer) {

        $start_current_year = date('Y-01-01');
        $datetime_current_year = new \DateTime($start_current_year);
        $end_time =$datetime_current_year
            ->sub(\DateInterval::createFromDateString('1 year'));
        $from_time = $datetime_current_year->sub(\DateInterval::createFromDateString('1 year'));

        $label = 'График заселенности за '.$from_time->format('Y').' год';

        $from_time = \Yii::$app->formatter->asTimestamp($from_time);
        $end_time = \Yii::$app->formatter->asTimestamp($end_time);

        $events = self::getEventsForOccupancyFromAndToTime($id_customer, $from_time, $end_time);

        return self::preProcessingDataForGraphic($events, $label);
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

    public static function getPointReportCurrentMonth($id_customer) {

        $start_current_month = date('Y-m-01');
        $start_current_month = \Yii::$app->formatter->asTimestamp($start_current_month);

        $events = self::find()
            ->select('point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $start_current_month])
            ->asArray()
            ->all();

        if (count($events) == 0) {
            return ['is_view'   => false];
        }
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
            'label' => 'Отчет по точкам контроля за месяц',
            'data'  => [$events_not_touch, $events_part_replace, $events_full_replace, $events_caught],
            'backgroundColor'   => ["#3e95cd", "#3463a2", "#894ea2", "green"]
        ];
        return [
            'labels'    => ["Приманка не тронута", "Частичная замена приманки", "Полная замена приманки", "Пойман вредитель"],
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
}
