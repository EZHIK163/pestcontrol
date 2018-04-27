<?php

namespace app\models\customer;

use Yii;

/**
 * This is the model class for table "public.disinfectant".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $description
 * @property string $code
 * @property string $value
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Disinfectant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.disinfectant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description', 'code', 'value'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
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
            'description' => 'Description',
            'code' => 'Code',
            'value' => 'Value',
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

    public static function getCurrentMonth($id_customer) {
        $start_current_month = date('Y-m-01');
        $start_current_month = \Yii::$app->formatter->asTimestamp($start_current_month);

        return self::getStartFromTime($start_current_month, $id_customer);
    }

    public static function getPreviousMonth($id_customer) {
        $start_current_month = date('Y-m-01');
        $datetime_current_month = new \DateTime($start_current_month);
        $start_current_month = \Yii::$app->formatter->asTimestamp($start_current_month);

        $start_previous_month = $datetime_current_month->sub(\DateInterval::createFromDateString('1 month'));

        return self::getStartFromTime($start_previous_month, $id_customer, $start_current_month);
    }


    public function getStartFromTime($start_from_time, $id_customer, $end_to_time = null) {

        $disinfectants = self::find()
            ->asArray()
            ->all();

        $events = Events::find()
            ->select('events.id, point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer]);
        if (!is_null($end_to_time)) {
            $events = $events
                ->where(['>=', 'events.created_at', $start_from_time])
                ->where(['<', 'events.created_at', $end_to_time])
                ->asArray()
                ->all();
        } else {
            $events = $events->where(['>=', 'events.created_at', $start_from_time])
                ->asArray()
                ->all();
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
        $data = [];
        foreach ($disinfectants as &$disinfectant) {
            switch($disinfectant['code']) {
                case 'alt-klej':
                    $data[0][$disinfectant['code']] = count($events) * floatval($disinfectant['value']);
                    //$disinfectant['count'] =
                    break;
                case 'shturm_brickety':
                    $data[0][$disinfectant['code']] = ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;
                    break;
                case 'shturm_granuly':
                    $data[0][$disinfectant['code']] =  ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;
                    break;
                case 'indan-block':
                    $data[0][$disinfectant['code']] =  ($events_part_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;
                    break;
                case 'rattidion':
                    $data[0][$disinfectant['code']] = ($events_full_replace * floatval($disinfectant['value']))
                        / 2 + $events_full_replace;
                    break;
            }
        }

        return $data;
    }
}
