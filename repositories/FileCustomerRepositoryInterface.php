<?php
namespace app\repositories;

use app\dto\FileCustomer;
use app\dto\FileCustomerType;

/**
 * Interface PointStatusRepositoryInterface
 * @package app\repositories
 */
interface FileCustomerRepositoryInterface
{
    /**
     * @param $id
     * @throws FileCustomerRepositoryInterface
     * @return FileCustomer
     */
    public function get($id);

    /**
     * @param FileCustomer $file
     * @return FileCustomer
     */
    public function add(FileCustomer $file);

    /**
     * @param FileCustomer $file
     * @return FileCustomer
     */
    public function save(FileCustomer $file);

    /**
     * @param FileCustomer $file
     * @return FileCustomer
     */
    public function remove(FileCustomer $file);

    /**
     * @return FileCustomer[]
     */
    public function all();

    /**
     * @param $idFile
     * @return FileCustomer
     */
    public function getByIdFile($idFile);

    /**
     * @param $code
     * @return FileCustomer[]
     */
    public function getItemsByTypeCode($code);

    /**
     * @return FileCustomerType[]
     */
    public function getTypes();

    /**
     * @param $id
     * @return FileCustomerType
     */
    public function getTypeById($id);
}
