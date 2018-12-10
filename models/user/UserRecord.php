<?php

namespace app\models\user;

use app\entities\CustomerRecord;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "auth.users".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property bool $is_active
 */
class UserRecord extends ActiveRecord implements IdentityInterface {


    public static function tableName()
    {
        return 'auth.users';
    }

    public function rules()
    {
        return [
            ['id', 'number'],
            ['username', 'required'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'max' => 256],
            ['auth_key', 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        $return = parent::beforeSave($insert);
        if ($this->isAttributeChanged('password')) {
            $this->password = \Yii::$app->security->generatePasswordHash($this->password);
        }
        if ($this->isNewRecord) {
            $this->auth_key = \Yii::$app->security->generateRandomString($length = 255);
        }
        return $return;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }

    public function behaviors()
    {
        return [
            'timestamp' =>  \yii\behaviors\TimestampBehavior::class,
            'blame'     => \yii\behaviors\BlameableBehavior::class
        ];
    }

    public static function getUsers() {
        return UserRecord::find()
            ->where(['is_active'    => true])
            ->all();
    }
    public static function getUsersForAdmin() {
        $users = self::getUsers();
        $users_with_customer = [];
        $rbac = \Yii::$app->authManager;
        foreach ($users as $user) {
            $customer = isset($user->customer->name) ? $user->customer->name : '';
            $role = $rbac->getRoleByUser($user->id)->description;
            $users_with_customer [] = [
                'id'        => $user->id,
                'username'  => $user->username,
                'customer'  => $customer,
                'role'      => $role
            ];
        }
        return $users_with_customer;
    }

    public static function getUsersForDropDownList() {
        $users = self::getUsers();
        return ArrayHelper::map($users, 'id', 'username');
    }
//    public function getUserById($id) {
//        $user = $this->findOne($id);
//        $this->username = $user->username;
//        $rbac = \Yii::$app->authManager;
//        $role = $rbac->getRoleByUser($user->id)->name;
//        $this->role = $role;
//        $id_customer = isset($user->customer->id) ? $user->customer->id : null;
//        $this->id_customer = $id_customer;
//        /*$users_with_customer = [];
//        $rbac = \Yii::$app->authManager;
//        $customer = isset($user->customer->name) ? $user->customer->name : '';
//        $role = $rbac->getRoleByUser($user->id)->description;
//        $users_with_customer [] = [
//            'id'        => $user->id,
//            'username'  => $user->username,
//            'customer'  => $customer,
//            'role'      => $role
//        ];
//        return $users_with_customer;*/
//        return $user;
//    }

    public static function getUserById($id) {
        $user = UserRecord::findOne($id);
        return $user;
    }


    public function getCustomer()
    {
        return $this->hasOne(CustomerRecord::class, ['id_user_owner' => 'id']);
    }



    public static function deleteUser($id) {
        CustomerRecord::clearCustomerOnIdOwner($id);
        $user = UserRecord::findOne($id);
        $user->delete();
    }

}