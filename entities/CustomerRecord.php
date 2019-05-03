<?php

namespace app\entities;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property bool $is_active
 * @property string $name
 * @property string $code
 * @property int $id_user_owner
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 * @property DisinfectantRecord[] $disinfectants
 * @property UserRecord $owner
 * @property CustomerContactRecord $contacts
 */
class CustomerRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.customers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'created_by', 'updated_at', 'updated_by', 'id_user_owner'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'is_active'  => 'Is Active',
            'name'       => 'Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
    public function getOwner()
    {
        return $this->hasOne(UserRecord::class, ['id' => 'id_user_owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(CustomerContactRecord::class, ['id_customer' => 'id'])
            ->where(['is_active'   => true]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisinfectants()
    {
        return $this->hasMany(DisinfectantRecord::class, ['id' => 'id_disinfectant'])
            ->viaTable('customer_disinfectant', ['id_customer' => 'id'], function ($query) {
                // @var \yii\db\ActiveQuery $query
                $query->andWhere(['is_active' => true]);
            })
            ->andWhere(['is_active' => true]);
    }
}
