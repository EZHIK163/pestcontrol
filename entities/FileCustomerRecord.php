<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
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
 * @property bool $is_enable
 * @property FileCustomerTypeRecord $fileCustomerType
 */
class FileCustomerRecord extends ActiveRecord
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
            [['id_file', 'id_customer', 'id_file_customer_type',
                'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_file', 'id_customer', 'id_file_customer_type',
                'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['id_file'], 'exist', 'skipOnError' => true,
                'targetClass' => FileRecord::class, 'targetAttribute' => ['id_file' => 'id']],
            [['id_file_customer_type'], 'exist', 'skipOnError' => true,
                'targetClass' => FileCustomerTypeRecord::class, 'targetAttribute' => ['id_file_customer_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'is_active'             => 'Is Active',
            'name'                  => 'Name',
            'id_file'               => 'Id File',
            'id_customer'           => 'Id Customer',
            'id_file_customer_type' => 'Id File Customer Type',
            'title'                 => 'Наименование файла',
            'created_at'            => 'Created At',
            'created_by'            => 'Created By',
            'updated_at'            => 'Updated At',
            'updated_by'            => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => TimestampBehavior::class,
            'blame'     => BlameableBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::class, ['id' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(FileRecord::class, ['id' => 'id_file']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoints()
    {
        return $this->hasMany(PointRecord::class, ['id_file_customer' => 'id'])
            ->where(['is_active'  => true]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileCustomerType()
    {
        return $this->hasOne(FileCustomerTypeRecord::class, ['id' => 'id_file_customer_type']);
    }
}
