<?php

namespace app\models\user;

use app\models\customer\Customer;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
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

    public $role;
    public $id_customer;

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
            ['password', 'required'],
            ['password', 'string', 'max' => 256],
            ['auth_key', 'string', 'max' => 255]
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

    public static function getUsersForAdmin() {
        $users = UserRecord::find()
            ->where(['is_active'    => true])
            ->all();
        $users_with_customer = [];
        foreach ($users as $user) {
            $customer = isset($user->customer->name) ? $user->customer->name : '';
            $users_with_customer [] = [
                'id'        => $user->id,
                'username'  => $user->username,
                'customer'  => $customer
            ];
        }
        return $users_with_customer;
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id_user_owner' => 'id']);
    }

    public function addUser($post) {
        $username = $post['UserRecord']['username'];
        $password = $post['UserRecord']['password'];
        $code_role = $post['UserRecord']['role'];
        $id_customer = $post['UserRecord']['id_customer'];
        $this->id_customer = (int)$id_customer;
        $this->username = $username;
        $this->password = $password;
        $this->save();

        $rbac = \Yii::$app->authManager;
        $role = $rbac->getRole($code_role);
        $rbac->assign($role, $this->id);
    }

}