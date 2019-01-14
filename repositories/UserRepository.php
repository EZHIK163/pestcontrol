<?php
namespace app\repositories;

use app\dto\User;
use app\dto\UserRole;
use app\entities\RoleRecord;
use app\entities\UserRecord;
use app\exceptions\UserNotFound;
use app\utilities\MyRbacManager;
use RuntimeException;
use Yii;

/**
 * Class UserRepository
 * @package app\repositories
 */
class UserRepository implements UserRepositoryInterface
{
    private $customerRepository;

    /**
     * UserRepository constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $id
     * @return User
     * @throws UserNotFound
     */
    public function get($id)
    {
        /**
         * @var UserRecord $userRecord
         */
        $userRecord = $this->findOrFail($id);

        $user = $this->fillUser($userRecord);

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws \Throwable
     */
    public function add(User $user)
    {
        $userRecord = new UserRecord();

        $userRecord = $this->fillUserRecord($userRecord, $user);

        if (!$userRecord->insert()) {
            throw new RuntimeException();
        }

        $user->setId($userRecord->id);

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(User $user)
    {
        /**
         * @var UserRecord $userRecord
         */
        $userRecord = $this->findOrFail($user->getId());

        $userRecord = $this->fillUserRecord($userRecord, $user);

        $userRecord->update();

        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(User $user)
    {
        $userRecord = $this->findOrFail($user->getId());

        $userRecord->is_active = false;

        if (!$userRecord->update()) {
            throw new \RuntimeException();
        }

        $user->setIsActive(false);

        return $user;
    }

    /**
     * @return User[]
     */
    public function all()
    {
        $userRecords = UserRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $users = [];
        /**
         * @var UserRecord $userRecord
         */
        foreach ($userRecords as $userRecord) {
            $users [] = $this->fillUser($userRecord);
        }

        return $users;
    }

    /**
     * @param $id
     * @return UserRecord
     * @throws UserNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var UserRecord $user
         */
        if (!($user = UserRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new UserNotFound();
        }

        return $user;
    }

    /**
     * @param UserRecord $userRecord
     * @return User
     */
    private function fillUser($userRecord)
    {
        /**
         * @var MyRbacManager $authManager
         */
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRoleByUser($userRecord->id)->name;

        $customer = isset($userRecord->customer->id)
            ? $this->customerRepository->get($userRecord->customer->id)
            : null;

        $user = (new User())
            ->setId($userRecord->id)
            ->setUsername($userRecord->username)
            ->setPassword($userRecord->password)
            ->setRole($role)
            ->setCustomer($customer);

        return $user;
    }

    /**
     * @param UserRecord $userRecord
     * @param User $user
     * @return UserRecord
     * @throws \Exception
     */
    private function fillUserRecord($userRecord, $user)
    {
        $userRecord->username = $user->getUsername();
        if (!empty($user->getPassword())) {
            $userRecord->password = $user->getPassword();
        }

        return $userRecord;
    }

    /**
     * @return UserRole[]
     */
    public function getRoles()
    {
        $roleRecords = RoleRecord::find()->all();

        $roles = [];
        foreach ($roleRecords as $roleRecord) {
            $roles [] = (new UserRole())
                ->setDescription($roleRecord->description)
                ->setName($roleRecord->name);
        }

        return $roles;
    }
}
