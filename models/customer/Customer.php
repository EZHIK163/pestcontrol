<?php

namespace app\models\customer;

use app\models\user\UserRecord;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.customers".
 *
 * @property int $id
 * @property bool $is_active
 * @property string $name
 * @property int $id_user_owner
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.customers';
    }

    public function getOwner() {
        return $this->hasOne(UserRecord::class, ['id' => 'id_user_owner']);
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
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_user_owner'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['id_user_owner' => 'id']]
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

    public static function getCustomers() {
        return Customer::find()
            ->where(['is_active'    => true])
            ->all();
    }

    public static function getCustomer($id) {
        return Customer::findOne($id);
    }

    public static function getCustomerForDropDownList() {
        $customers = self::getCustomers();
        return ArrayHelper::map($customers,'id','name');
    }

    public static function setIdUserOwner($id_customer, $id_user) {
        self::clearCustomerOnIdOwner($id_user);
        $customer = self::getCustomer($id_customer);
        $customer->id_user_owner = $id_user;
        $customer->save();
    }

    public static function clearCustomerOnIdOwner($id_owner) {
        $customers = Customer::findAll(['id_user_owner'    => $id_owner]);
        foreach ($customers as $customer) {
            $customer->id_user_owner = null;
            $customer->save();
        }
    }
    public static function getCustomersForManager() {
        $customers = Customer::getCustomers();
        $finish_customers = [];
        foreach ($customers as &$customer) {
            if (!is_null($customer->owner)) {
                $name_owner = $customer->owner->username;
            } else {
                $name_owner = '-';
            }
            $finish_customers [] = [
                'id'            => $customer->id,
                'name_owner'    => $name_owner,
                'name'          => $customer->name
            ];
        }
        return $finish_customers;
    }

    public static function deleteCustomer($id) {
        $customer = Customer::findOne($id);
        $customer->delete();
    }
}
