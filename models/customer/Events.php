<?php

namespace app\models\customer;

use Yii;
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
            ->where(['>=', 'events.created_at', $start_current_month])
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
}
