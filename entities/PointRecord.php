<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "public.points".
 *
 * @property int $id
 * @property bool $is_active
 * @property bool $is_enable
 * @property int $id_point_status
 * @property string $title
 * @property double $x_coordinate
 * @property double $y_coordinate
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property int $id_file_customer
 * @property int $id_internal
 */
class PointRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_point_status', 'created_at', 'created_by',
                'updated_at', 'updated_by', 'id_file_customer', 'id_internal'], 'default', 'value' => null],
            [['id_point_status', 'created_at', 'created_by',
                'updated_at', 'updated_by', 'id_file_customer', 'id_internal'], 'integer'],
            [['x_coordinate', 'y_coordinate'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['id_file_customer'], 'exist', 'skipOnError' => true,
                'targetClass' => FileCustomerRecord::class, 'targetAttribute' => ['id_file_customer' => 'id']],
            [['id_point_status'], 'exist', 'skipOnError' => true,
                'targetClass' => PointStatusRecord::class, 'targetAttribute' => ['id_point_status' => 'id']],
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
            'id_point_status'       => 'Id Point Status',
            'title'                 => 'Title',
            'x_coordinate'          => 'X Coordinate',
            'y_coordinate'          => 'Y Coordinate',
            'created_at'            => 'Created At',
            'created_by'            => 'Created By',
            'updated_at'            => 'Updated At',
            'updated_by'            => 'Updated By',
            'id_file_customer'      => 'Id File Customer',
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
    public function getEvents()
    {
        return $this->hasMany(EventRecord::class, ['id_point' => 'id'])->where(['is_active'  => true]);
    }
}
