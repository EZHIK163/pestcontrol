<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "public.customer_contact".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $id_customer
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class CustomerContactRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.customer_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_customer', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_customer', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'email', 'phone'], 'string', 'max' => 255],
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerRecord::class, 'targetAttribute' => ['id_customer' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'is_active'     => 'Is Active',
            'id_customer'   => 'Id Customer',
            'name'          => 'Name',
            'email'         => 'Email',
            'phone'         => 'Phone',
            'created_at'    => 'Created At',
            'created_by'    => 'Created By',
            'updated_at'    => 'Updated At',
            'updated_by'    => 'Updated By',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' =>  TimestampBehavior::class,
            'blame'     => BlameableBehavior::class
        ];
    }
}
