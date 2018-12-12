<?php
namespace app\repositories;

use app\dto\Customer;

/**
 * Interface CustomerRepositoryInterface
 * @package app\repositories
 */
interface CustomerRepositoryInterface
{
    /**
     * @param $id
     * @return Customer
     */
    public function get($id);

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function add(Customer $customer);

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function save(Customer $customer);

    /**
     * @param Customer $customer
     * @return Customer
     */
    public function remove(Customer $customer);

    /**
     * @return Customer[]
     */
    public function all();

    /**
     * @param $idUserOwner
     * @return Customer
     */
    public function getByIdUser($idUserOwner);

    /**
     * @param $code
     * @return Customer
     */
    public function getByByCode($code);
}
