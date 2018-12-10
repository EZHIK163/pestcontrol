<?php

namespace app\entities;

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
 * @property string $form_of_facility
 * @property string $active_substance
 * @property string $concentration_of_substance
 * @property string $manufacturer
 * @property string $terms_of_use
 * @property string $place_of_application
 */
class DisinfectantRecord extends \yii\db\ActiveRecord
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

    public static function getFromPeriod($id_customer, $from_datetime, $to_datetime) {

        $start_timestamp = \Yii::$app->formatter->asTimestamp($from_datetime);
        $end_timestamp = \Yii::$app->formatter->asTimestamp($to_datetime);

        return self::getStartFromTime($start_timestamp, $end_timestamp, $id_customer);
    }

    public static function getStartFromTime($start_from_time, $end_to_time, $id_customer) {

        $disinfectants = self::find()
            ->select('disinfectant.value, disinfectant.id, disinfectant.code, disinfectant.description')
            ->join('inner join', 'public.customer_disinfectant', 'customer_disinfectant.id_disinfectant = disinfectant.id')
            ->where(['disinfectant.is_active'    => true])
            ->andWhere(['customer_disinfectant.is_active'    => true])
            ->andWhere(['customer_disinfectant.id_customer'  => $id_customer])
            ->asArray()
            ->all();

        $events = Events::find()
            ->select('events.id, point_status.code')
            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
            ->where(['events.id_customer'  => $id_customer])
            ->andWhere(['>=', 'events.created_at', $start_from_time])
            ->andWhere(['<', 'events.created_at', $end_to_time])
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
        $data = [];
        $setting_column = [];
        foreach ($disinfectants as &$disinfectant) {
            switch($disinfectant['code']) {
                case 'alt-klej':
                    $data[0][$disinfectant['code']] = $events_caught * floatval($disinfectant['value']);
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

            $setting_column [] = [
                'attribute' => $disinfectant['code'],
                'header'    => $disinfectant['description']
            ];
        }

        $data['setting_column'] = $setting_column;

        return $data;
    }

    static function getDisinfectants() {
        $disinfectants = self::find()
            ->select('id, description, value')
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->asArray()
            ->all();
        return $disinfectants;
    }

    static function getItem($id) {
        $disinfectant = self::findOne($id)->toArray();
        return $disinfectant;
    }

    static function getItemByCode($code) {
        $disinfectant = self::findOne(compact('code'))->toArray();
        return $disinfectant;
    }

    static function saveItem($id, $title, $value, $form_of_facility, $active_substance,
            $concentration_of_substance, $manufacturer,
            $terms_of_use, $place_of_application) {
        $item = self::findOne($id);

        $item->value = $value;
        $item->description = $title;
        $item->form_of_facility = $form_of_facility;
        $item->active_substance = $active_substance;
        $item->concentration_of_substance = $concentration_of_substance;
        $item->manufacturer = $manufacturer;
        $item->terms_of_use = $terms_of_use;
        $item->place_of_application = $place_of_application;

        $item->save();
    }

    static function addItem($title, $value, $form_of_facility, $active_substance,
                            $concentration_of_substance, $manufacturer,
                            $terms_of_use, $place_of_application) {
        $item = new DisinfectantRecord();

        $item->value = $value;
        $item->description = $title;
        $item->form_of_facility = $form_of_facility;
        $item->active_substance = $active_substance;
        $item->concentration_of_substance = $concentration_of_substance;
        $item->manufacturer = $manufacturer;
        $item->terms_of_use = $terms_of_use;
        $item->place_of_application = $place_of_application;

        $item->save();
    }


    static function deleteDisinfectant($id) {
        $item = self::findOne($id);

        $item->is_active = false;

        $item->save();
    }

    static function getDataForReport($id_customer, $from_datetime, $to_datetime) {
        $data = self::getFromPeriod($id_customer, $from_datetime, $to_datetime);
        unset($data['setting_column']);

        $result = [];
        foreach ($data[0] as $key => $item) {
            $disinfectant = self::getItemByCode($key);
            $result [] = [
                'value'                         => $item,
                'name'                          => $disinfectant['description'],
                'form_of_facility'              => $disinfectant['form_of_facility'],
                'active_substance'              => $disinfectant['active_substance'],
                'concentration_of_substance'    => $disinfectant['concentration_of_substance'],
                'manufacturer'                  => $disinfectant['manufacturer'],
                'terms_of_use'                  => $disinfectant['terms_of_use'],
                'place_of_application'          => $disinfectant['place_of_application'],
                'disinfector'                   => ''
            ];
        }

        return $result;
    }
}
