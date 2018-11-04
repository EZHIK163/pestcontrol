<?php

namespace app\models\customer;

use app\models\file\Files;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.file_customer".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $id_file
 * @property int $id_customer
 * @property int $id_file_customer_type
 * @property string $title
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class FileCustomer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.file_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_file', 'id_customer', 'id_file_customer_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_file', 'id_customer', 'id_file_customer_type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => Files::class, 'targetAttribute' => ['id_file' => 'id']],
            [['id_file_customer_type'], 'exist', 'skipOnError' => true, 'targetClass' => FileCustomerType::class, 'targetAttribute' => ['id_file_customer_type' => 'id']],
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
            'name' => 'Name',
            'id_file' => 'Id File',
            'id_customer' => 'Id Customer',
            'id_file_customer_type' => 'Id File Customer Type',
            'title' => 'Наименование файла',
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

    public static function addFileCustomer($id_file, $id_customer, $title, $id_file_customer_type) {
        $file_customer = new FileCustomer();
        $file_customer->title = $title;
        $file_customer->id_customer = $id_customer;
        $file_customer->id_file = $id_file;
        $file_customer->id_file_customer_type = $id_file_customer_type;
        $file_customer->save();
    }

    public static function getRecommendationsForAdmin() {
        $file_customer_type_recommendations = FileCustomerType::findOne(['code' => 'recommendations']);
        $recommendations = [];
        $files = $file_customer_type_recommendations->files;
        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        foreach ($files as $file) {
            $recommendations [] = [
                'id_file_customer'  => $file->id,
                'title'             => $file->title,
                'customer'          => $file->customer->name,
                'date_create'       => $file->getDateTimeCreatedAt(),
                'url'               => $action_download.$file->file->id
            ];
        }
        return $recommendations;
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'id_customer']);
    }

    public function getFile()
    {
        return $this->hasOne(Files::class, ['id' => 'id_file']);
    }

    public function getPoints()
    {
        return $this->hasMany(Points::class, ['id_file_customer' => 'id'])
            ->where(['is_active'  => true]);
    }

    public function getDateTimeCreatedAt() {
         return date("d.m.y", $this->created_at);
    }

    public static function getRecommendationsForAccount() {
        $search = '';
        return self::getFilesForAdmin('recommendations', $search);
    }

    public static function getSchemePointControlForAdmin($search) {
        $scheme_point_control = self::getFilesForAdmin('scheme_point_control', $search);
        $result = ArrayHelper::index($scheme_point_control, null, 'customer');
        return $result;
    }

    public static function getSchemePointControlCustomer($id_customer, $search) {
        $scheme_point_control = self::getFilesCustomer('scheme_point_control', $id_customer, $search);
        //$result = ArrayHelper::index($scheme_point_control, null, 'customer');
        return $scheme_point_control;
    }

    private static function getFilesForAdmin($code, $search) {
        $file_customer_type = FileCustomerType::findOne(['code' => $code]);
        $result = [];
        if (!isset($file_customer_type->files)) {
            return $result;
        }

        if (!empty($search)) {
//            $files = $file_customer_type->getFiles()
//                ->where(['like', 'title', '%'.$search.'%', false])
//                ->all();
            $files = $file_customer_type->getFiles()
                ->leftJoin('public.points', 'points.id_file_customer = file_customer.id')
                ->andWhere(['or',
                    ['like', 'file_customer.title', '%'.$search.'%', false],
                    ['points.id_internal' => $search]])
                ->all();
        } else {
            $files = $file_customer_type->getFiles()->all();
        }

        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        foreach ($files as $file) {
            $result [] = [
                'id_file_customer'  => $file->id,
                'title'             => $file->title,
                'customer'          => $file->customer->name,
                'date_create'       => $file->getDateTimeCreatedAt(),
                'url'               => $action_download.$file->file->id
            ];
        }
        return $result;
    }

    private static function getFilesCustomer($code, $id_customer, $search) {
        $file_customer_type = FileCustomerType::findOne(['code' => $code]);
        $result = [];
        if (!isset($file_customer_type->files)) {
            return $result;
        }

        if (!empty($search)) {
            $files = $file_customer_type->getFiles()
                ->leftJoin('public.points', 'points.id_file_customer = file_customer.id')
                ->where(['file_customer.id_customer'   => $id_customer])
                ->andWhere(['or',
                    ['like', 'file_customer.title', '%'.$search.'%', false],
                    ['points.id_internal' => $search]])
                ->all();
        } else {
            $files = $file_customer_type->getFiles()
                ->where(['id_customer'   => $id_customer])
                ->all();
        }


        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        foreach ($files as $file) {
            $result [] = [
                'id_file_customer'  => $file->id,
                'title'             => $file->title,
                'customer'          => $file->customer->name,
                'date_create'       => $file->getDateTimeCreatedAt(),
                'url'               => $action_download.$file->file->id
            ];
        }
        return $result;
    }

    public static function getSchemeForEdit($id, $is_add_free_points = false, $date_from = null, $date_to = null) {
        $file_customer = self::findOne(['id_file'   => $id]);
        $file = $file_customer->file;
        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        $points = $file_customer->points;
        $id_customer = $file_customer->id_customer;
        //$count_points = 0;
        $finish_points = [];
        $max_id_internal_in_customer = self::getMaxIdInternal($id_customer);
        $ids_points = [];

        $datetime_from = new \DateTime($date_from);
        $datetime_to = new \DateTime($date_to);

        $interval_days = (int)$datetime_to->diff($datetime_from)->format('%a');

        $mode = null;
        if ($interval_days > 0 && $interval_days <= 31) {
            $mode = 'month';
        } else if ($interval_days >= 32 && $interval_days <= 93) {
            $mode = 'quarter';
        } else if ($interval_days >= 94) {
            $mode = 'year';
        }

        foreach ($points as $point) {
            if (!$is_add_free_points && ($point->x_coordinate <= 0 or $point->y_coordinate <= 0)) {
                continue;
            }
            $events = $point->events;

            $type_marker = self::getTypeMarker($events, $mode);

            //TODO MSMR На основании событий менять цвет маркера
            $img_src = \Yii::$app->urlManager->createAbsoluteUrl(['/']). $type_marker.'.png';
            $finish_points [] = [
                'x'                 => $point->x_coordinate,
                'y'                 => $point->y_coordinate,
                'img_src'           => $img_src,
                'id_internal'       => $point->id_internal,
                'is_new'            => false,
                'id'                => $point->id
            ];
            $ids_points [] = $point->id;
            //$count_points++;
        }
        if ($is_add_free_points) {
            $free_points = Points::getFreePoints();
            foreach ($free_points as $free_point) {
                if (in_array($free_point['id'], $ids_points)) {
                    continue;
                }
                $finish_points [] = [
                    'x' => $free_point['x_coordinate'],
                    'y' => $free_point['y_coordinate'],
                    'img_src' => \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'blue_marker.png',
                    'id_internal' => $free_point['id_internal'],
                    'is_new' => false,
                    'id' => $free_point['id']
                ];
            }
        }
        $result = [
            'img'                       => $action_download.$file->id,
            'img_src_new_point'         => \Yii::$app->urlManager->createAbsoluteUrl(['/']). 'blue_marker.png',
            'max_id_internal_in_customer'  =>  $max_id_internal_in_customer,
            'id_file_customer'          => $file_customer->id,
            'points'                    => $finish_points
            ];

        return $result;
    }

    static function getTypeMarker($events, $mode) {

        $count_red_events = 0;
        $count_green_events = 0;
        foreach ($events as $event) {
            switch($event->id_point_status) {
                case 1:
                case 2:
                case 3:
                $count_green_events++;
                    break;
                case 4:
                case 5:
                case 6:
                $count_red_events++;
                    break;
            }
        }

        $marker = 'blue_marker';
        switch ($mode) {
            case 'month':
                if ($count_red_events > 3) {
                    $marker = 'red_marker';
                } else if ($count_green_events > 3) {
                    $marker = 'green_marker';
                }
                break;
            case 'quarter':
                if ($count_red_events > 6) {
                    $marker = 'red_marker';
                } else if ($count_green_events > 6) {
                    $marker = 'green_marker';
                }
                break;
            case 'year':
                if ($count_red_events > 20) {
                    $marker = 'red_marker';
                } else if ($count_green_events > 20) {
                    $marker = 'green_marker';
                }
                break;
        }
        return $marker; //blue_marker, red_marker, green_marker
    }

    static function getItem($id) {
        return self::findOne($id);
    }

    public static function savePoints($id_file_customer, $points) {
        $code = 'not_touch';
        $id_status_not_touch = PointStatus::getIdItemByCode($code);

        $file_customer = self::getItem($id_file_customer);

        $id_customer = $file_customer->id_customer;

        foreach ($points as $point) {
            if ($point['is_new'] === true) {
                $new_point = new Points();
                $new_point->id_file_customer = $id_file_customer;
                $new_point->x_coordinate = $point['x'];
                $new_point->y_coordinate = $point['y'];
                $new_point->id_point_status = $id_status_not_touch;
                $new_point->id_internal = $point['id_internal'];
                $new_point->save();
            } else {
                Points::savePoint($point['id_internal'], $id_customer, $point['x'], $point['y'], $id_file_customer);
                //$exist_point = Points::getPoint($point['id_internal'], $id_customer);
                //$exist_point->x_coordinate = $point['x'];
                //$exist_point->y_coordinate = $point['y'];
                //$exist_point->save();
            }
        }
    }

    static function getMaxIdInternal($id_customer) {
        $sql = "
        SELECT max(p.id_internal) 
        FROM public.points as p
        JOIN public.file_customer as fc ON fc.id = p.id_file_customer
        WHERE fc.id_customer = :id_customer";
        $point = Yii::$app->db->createCommand($sql)
            ->bindValue(':id_customer', $id_customer)
            ->queryOne();
        if (is_null($point['max'])) {
            return 1;
        }
        return $point['max'] + 1;
    }

    static function getSchemePointControlForDropDownList($id_customer) {

        $scheme = self::getSchemePointControlCustomer($id_customer, '');

        return ArrayHelper::map($scheme, 'id_file_customer', 'title');
    }

    static function getSchemeForStat($id, $from_datetime, $to_datetime) {

        $scheme = self::findOne(compact('id'));

//        $events = self::find()
//            ->select('events.id_external, point_status.code, events.created_at, events.count')
//            ->join('inner join', 'public.point_status', 'point_status.id = events.id_point_status')
//            ->where(compact('id_customer'))
//            ->andWhere(['>=', 'events.created_at', $start_timestamp])
//            ->orderBy('events.created_at ASC')
//            ->asArray()
//            ->all();


        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';

        $model = [
            'id_file_customer'  => $scheme->id,
            'title'             => $scheme->title,
            'customer'          => $scheme->customer->name,
            'date_create'       => $scheme->getDateTimeCreatedAt(),
            'url'               => $action_download.$scheme->file->id
        ];

        return $model;

    }
}
