<?php

namespace app\models\customer;

use Yii;

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
class CustomerContact extends \yii\db\ActiveRecord
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
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\user\UserRecord::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['id_customer'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['id_customer' => 'id']],
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
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
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

    static function updateContacts($contacts, $id_customer) {
        self::clearContacts($id_customer);
        foreach ($contacts as $contact) {
            if (!empty($contact['id'])) {
                $exist_contact = self::findOne(
                    [
                        'id'   => $contact['id'],
                    ]
                );
                $exist_contact->name = $contact['name'];
                $exist_contact->email = $contact['email'];
                $exist_contact->phone = $contact['phone'];
                $exist_contact->is_active = true;
                $exist_contact->save();
            } else {
                $new_contact = new CustomerContact();
                $new_contact->name = $contact['name'];
                $new_contact->email = $contact['email'];
                $new_contact->phone = $contact['phone'];
                $new_contact->id_customer = $id_customer;
                $new_contact->save();
            }
        }
    }

    static function getContacts($id_customer) {
        $contacts = self::find()
            ->select('id, name, email, phone')
            ->where(['id_customer'    => $id_customer])
            ->andWhere(['is_active' => true])
            ->orderBy('id ASC')
            ->asArray()
            ->all();
        return $contacts;
    }

    static function clearContacts($id_customer) {
        $contacts = self::findAll(['id_customer'    => $id_customer]);
        foreach ($contacts as $contact) {
            $contact->is_active = false;
            $contact->save();
        }
    }
}
