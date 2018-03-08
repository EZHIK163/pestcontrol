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

    public function getDateTimeCreatedAt() {
         return date("d.m.y", $this->created_at);
    }

    public static function getRecommendationsForAccount() {
        return self::getFilesForAdmin('recommendations');
    }

    public static function getSchemePointControlForAdmin() {
        $scheme_point_control = self::getFilesForAdmin('scheme_point_control');
        $result = ArrayHelper::index($scheme_point_control, null, 'customer');
        return $result;
    }

    private static function getFilesForAdmin($code) {
        $file_customer_type = FileCustomerType::findOne(['code' => $code]);
        $result = [];
        $files = $file_customer_type->files;
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
}
