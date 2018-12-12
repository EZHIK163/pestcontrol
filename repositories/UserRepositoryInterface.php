<?php
namespace app\repositories;

use app\dto\User;
use app\dto\UserRole;

/**
 * Interface UserRepositoryInterface
 * @package app\repositories
 */
interface UserRepositoryInterface
{
    /**
     * @param $id
     * @return User
     */
    public function get($id);

    /**
     * @param User $user
     * @return User
     */
    public function add(User $user);

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user);

    /**
     * @param User $user
     * @return User
     */
    public function remove(User $user);

    /**
     * @return User[]
     */
    public function all();

    /**
     * @return UserRole[]
     */
    public function getRoles();

}
