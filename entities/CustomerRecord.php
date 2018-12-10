<?php

namespace app\entities;

use app\models\user\UserRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.customers".
 *
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
 * @property CustomerContact $contacts
 */
class CustomerRecord extends \yii\db\ActiveRecord
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

    public function getOwner()
    {
        return $this->hasOne(UserRecord::class, ['id' => 'id_user_owner']);
    }

    public function getContacts()
    {
        return $this->hasMany(CustomerContact::class, ['id_customer' => 'id'])
            ->where(['is_active'   => true]);
    }

    public function getDisinfectants()
    {
        return $this->hasMany(DisinfectantRecord::class, ['id' => 'id_disinfectant'])
            ->viaTable('customer_disinfectant', ['id_customer' => 'id'], function ($query) {
                    /* @var $query \yii\db\ActiveQuery */
                    $query->andWhere(['is_active' => true]);
                })
            ->andWhere(['is_active' => true]);
    }
//    public static function getCustomers() {
//        return Customer::find()
//            ->where(['is_active'    => true])
//            ->orderBy('id ASC')
//            ->all();
//    }
//
//    public static function getCustomer($id) {
//        return Customer::findOne($id);
//    }
//
//    public static function getCustomerForDropDownList() {
//        $customers = self::getCustomers();
//        return ArrayHelper::map($customers,'id','name');
//    }
//
//    static function getCustomerByIdUser($id_user_owner) {
//        return Customer::findOne(compact('id_user_owner'));
//    }
//
//    public static function setIdUserOwner($id_customer, $id_user) {
//        self::clearCustomerOnIdOwner($id_user);
//        $customer = self::getCustomer($id_customer);
//        $customer->id_user_owner = $id_user;
//        $customer->save();
//    }
//
//    public static function clearCustomerOnIdOwner($id_owner) {
//        $customers = Customer::findAll(['id_user_owner'    => $id_owner]);
//        foreach ($customers as $customer) {
//            $customer->id_user_owner = null;
//            $customer->save();
//        }
//    }
//
//    static function getCustomersForManageDisinfectants() {
//        $customers = Customer::getCustomers();
//        $finish_customers = [];
//        foreach ($customers as &$customer) {
//            $disinfectants = $customer->getDisinfectants()->asArray()->all();
//
//            $name_disinfectants = [];
//            foreach ($disinfectants as $disinfectant) {
//                $name_disinfectants [] = $disinfectant['description'];
//            }
//            $str_disinfectants = implode(', ', $name_disinfectants);
//            $finish_customers [] = [
//                'id'            => $customer->id,
//                'name'          => $customer->name,
//                'disinfectants' => $str_disinfectants
//            ];
//        }
//        return $finish_customers;
//    }
//    public static function getCustomersForManager() {
//        $customers = Customer::getCustomers();
//        $finish_customers = [];
//        foreach ($customers as &$customer) {
//            if (!is_null($customer->owner)) {
//                $name_owner = $customer->owner->username;
//            } else {
//                $name_owner = '-';
//            }
//            $contacts = $customer->contacts;
//            $finish_contacts = [];
//
//            foreach ($contacts as $contact) {
//                if (!empty($contact->phone)) {
//                    $finish_contacts []= $contact->name . ' - ' . $contact->email . ' - ' . $contact->phone;
//                } else {
//                    $finish_contacts []= $contact->name . ' - ' . $contact->email;
//                }
//            }
//            $str_contacts = implode(', ', $finish_contacts);
//            $finish_customers [] = [
//                'id'            => $customer->id,
//                'name_owner'    => $name_owner,
//                'name'          => $customer->name,
//                'contacts'      => $str_contacts
//            ];
//        }
//        return $finish_customers;
//    }
//
//    public static function deleteCustomer($id) {
//        $customer = Customer::findOne($id);
//        $customer->delete();
//    }
//
//    static function getDisinfectantsCustomer($id) {
//        $customer = Customer::findOne($id);
//        $disinfectants = $customer->getDisinfectants()->asArray()->all();
//        return $disinfectants;
//    }
//
//    static function setDisinfectantsCustomer($id, $disinfectants) {
//        foreach ($disinfectants as $disinfectant) {
//            $customer_disinfectant = CustomerDisinfectant::findOne([
//                'id_disinfectant'    => $disinfectant['id'],
//                'id_customer'        => $id
//            ]);
//
//            if (is_null($customer_disinfectant) && $disinfectant['is_set'] == true) {
//                $new_customer_disinfectant = new CustomerDisinfectant();
//                $new_customer_disinfectant->id_customer = $id;
//                $new_customer_disinfectant->id_disinfectant = $disinfectant['id'];
//                $new_customer_disinfectant->save();
//            } else if (!is_null($customer_disinfectant) && $disinfectant['is_set'] == true) {
//                $customer_disinfectant->is_active = true;
//                $customer_disinfectant->save();
//            } else if (!is_null($customer_disinfectant) && $disinfectant['is_set'] == false){
//                $customer_disinfectant->is_active = false;
//                $customer_disinfectant->save();
//            } else {
//
//            }
//        }
//    }
//
//    static function getIdCustomerByCode($code) {
//        $customer = self::findOne(compact('code'));
//        return $customer->id;
//    }
}
