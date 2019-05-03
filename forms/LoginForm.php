<?php
namespace app\forms;

use app\entities\UserRecord;
use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package app\forms
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe;
    public $user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword']
        ];
    }

    /**
     * @param $attributeName
     */
    public function validatePassword($attributeName)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser($this->username);
        if (!($user and $this->isCorrectHash($this->$attributeName, $user->password))) {
            $this->addError('password', 'Не верный логин или пароль');
        }
    }

    /**
     * @return bool
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->getUser($this->username);
        if (!$user) {
            return false;
        }

        return Yii::$app->user->login(
            $user,
            $this->rememberMe ? 3600 * 24 * 30 : 0
        );
    }

    /**
     * @param $username
     * @return UserRecord|null
     */
    private function getUser($username)
    {
        if (!$this->user) {
            $this->user = $this->fetchUser($username);
        }

        return $this->user;
    }

    /**
     * @param $username
     * @return UserRecord|null
     */
    private function fetchUser($username)
    {
        return UserRecord::findOne(compact('username'));
    }

    /**
     * @param $plaintext
     * @param $hash
     * @return bool
     */
    private function isCorrectHash($plaintext, $hash)
    {
        return Yii::$app->security->validatePassword($plaintext, $hash);
    }
}
