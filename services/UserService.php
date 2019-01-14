<?php
namespace app\services;

use app\dto\User;
use app\entities\UserRecord;
use app\repositories\UserRepositoryInterface;
use app\utilities\MyRbacManager;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class UserService
 * @package app\services
 */
class UserService
{
    private $userRepository;
    private $customerService;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param CustomerService $customerService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CustomerService $customerService
    ) {
        $this->userRepository = $userRepository;
        $this->customerService = $customerService;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function saveUser($user)
    {
        $this->userRepository->save($user);

        $this->setRole($user);

        $this->customerService->setIdUserOwner($user->getCustomer()->getId(), $user->getId());
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function addUser($user)
    {
        $user = $this->userRepository->add($user);

        $this->setRole($user);

        $this->customerService->setIdUserOwner($user->getCustomer()->getId(), $user->getId());
    }

    /**
     * @param $id
     * @return User
     */
    public function getUser($id)
    {
        $user = $this->userRepository->get($id);

        $this->fillRole($user);

        return $user;
    }

    /**
     * @return array
     */
    public function getUsersForAdmin()
    {
        $users = $this->userRepository->all();

        $preparedUsers = [];
        foreach ($users as $user) {
            $customer = $user->getCustomer() !== null
                ? $user->getCustomer()->getName()
                : '';
            $this->fillRole($user);
            $preparedUsers [] = [
                'id'        => $user->getId(),
                'username'  => $user->getUsername(),
                'customer'  => $customer,
                'role'      => $user->getRole()
            ];
        }
        return $preparedUsers;
    }

    /**
     * @return array
     */
    public function getUsersForDropDownList()
    {
        $users = $this->userRepository->all();
        foreach ($users as &$user) {
            $user = $user->toArray();
        }
        return ArrayHelper::map($users, 'id', 'username');
    }

    /**
     * @return array
     */
    public function getRolesForDropDownList()
    {
        $roles = $this->userRepository->getRoles();
        foreach ($roles as &$role) {
            $role = $role->toArray();
        }

        return ArrayHelper::map($roles, 'name', 'description');
    }

    /**
     * @param $id
     */
    public function deleteUser($id)
    {
        $user = $this->userRepository->get($id);
        $this->userRepository->remove($user);
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    private function setRole($user)
    {
        /**
         * @var MyRbacManager $authManager
         */
        $authManager = Yii::$app->authManager;
        $currentRole = $authManager->getRoleByUser($user->getId())->name;
        $role = $authManager->getRole($currentRole);
        $authManager->revoke($role, $user->getId());

        $role = $authManager->getRole($user->getRole());
        $authManager->assign($role, $user->getId());
    }

    /**
     * @param User $user
     */
    private function fillRole(&$user)
    {
        /**
         * @var MyRbacManager $authManager
         */
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRoleByUser($user->getId())->name;
        $user->setRole($role);
    }
}
