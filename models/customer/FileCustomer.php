<?php

namespace app\models\customer;

use app\models\file\Files;
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
        return $this->hasMany(Points::class, ['id_file_customer' => 'id']);
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

    public static function getSchemeForEdit($id) {
        $file_customer = self::findOne(['id_file'   => $id]);
        $file = $file_customer->file;
        $action_download = \Yii::$app->urlManager->createAbsoluteUrl(['/']) . 'site/download?id=';
        $points = $file_customer->points;
        $id_customer = $file_customer->id_customer;
        $count_points = 0;
        $finish_points = [];
        $max_id_internal_in_customer = self::getMaxIdInternal($id_customer);
        foreach ($points as $point) {
            $finish_points [] = [
                'x'                 => $point->x_coordinate,
                'y'                 => $point->y_coordinate,
                'img_src'           => \Yii::$app->urlManager->createAbsoluteUrl(['/']). 'blue_marker.png',
                'id_internal'       => $point->id_internal,
                'is_new'            => false,
                'id'                => $point->id
            ];
            $count_points++;
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
                Points::savePoint($point['id_internal'], $id_customer, $point['x'], $point['y']);
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
}
