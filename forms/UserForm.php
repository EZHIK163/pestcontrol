<?php
namespace app\forms;

use app\dto\Customer;
use app\dto\User;
use yii\base\Model;

/**
 * Class UserForm
 * @package app\models\user
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $password;
    public $role;
    public $idCustomer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'number'],
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[A-z]\w*$/i'],
            ['username', 'string', 'max' => 20],
            ['password', 'string', 'max' => 256],
            ['idCustomer', 'required'],
            ['role', 'required']
        ];
    }

    /**
     * @param User $user
     */
    public function fetchUser($user)
    {
        $this->username = $user->getUsername();
        $this->idCustomer = $user->getCustomer() !== null
            ? $user->getCustomer()->getId()
            : null;
        $this->id = $user->getId();
        $this->role = $user->getRole();
    }

    /**
     * @return User
     */
    public function fillUser()
    {
        $user = (new User())
            ->setId($this->id)
            ->setUsername($this->username)
            ->setPassword($this->password)
            ->setCustomer((new Customer())->setId($this->idCustomer))
            ->setRole($this->role);

        return $user;
    }
}
