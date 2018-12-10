<?php

namespace app\entities;

use Yii;

/**
 * This is the model class for table "customer_disinfectant".
 *
 * @property int $id
 * @property bool $is_active
 * @property int $id_customer
 * @property int $id_disinfectant
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property AuthUsers $createdBy
 * @property AuthUsers $updatedBy
 * @property Customers $customer
 * @property DisinfectantRecord $disinfectant
 */
class CustomerDisinfectant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_disinfectant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['id_customer', 'id_disinfectant', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['id_customer', 'id_disinfectant', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' =>  CustomerRecord::class, 'targetAttribute' => ['id_customer' => 'id']],
            [['id_disinfectant'], 'exist', 'skipOnError' => true, 'targetClass' => DisinfectantRecord::class, 'targetAttribute' => ['id_disinfectant' => 'id']],
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
            'id_customer' => 'Id Customer',
            'id_disinfectant' => 'Id Disinfectant',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(AuthUsers::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(AuthUsers::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customers::className(), ['id' => 'id_customer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisinfectant()
    {
        return $this->hasOne(DisinfectantRecord::className(), ['id' => 'id_disinfectant']);
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }
}
