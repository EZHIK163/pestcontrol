<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
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
class EventRecord extends ActiveRecord
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
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::class, 'targetAttribute' => ['id_customer' => 'id']],
            [['id_disinfector'], 'exist', 'skipOnError' => true, 'targetClass' => DisinfectorRecord::class, 'targetAttribute' => ['id_disinfector' => 'id']],
            [['id_point_status'], 'exist', 'skipOnError' => true, 'targetClass' => PointStatusRecord::class, 'targetAttribute' => ['id_point_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'is_active'         => 'Is Active',
            'id_customer'       => 'Id Customer',
            'id_disinfector'    => 'Id Disinfector',
            'id_external'       => 'Id External',
            'id_point_status'   => 'Id Point Status',
            'created_at'        => 'Created At',
            'created_by'        => 'Created By',
            'updated_at'        => 'Updated At',
            'updated_by'        => 'Updated By',
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
}
