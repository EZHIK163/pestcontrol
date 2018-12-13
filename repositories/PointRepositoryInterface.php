<?php
namespace app\repositories;

use app\dto\Point;

/**
 * Interface PointRepositoryInterfaceRepositoryInterface
 * @package app\repositories
 */
interface PointRepositoryInterface
{
    /**
     * @param $id
     * @return Point
     */
    public function get($id);

    /**
     * @param Point $point
     * @return Point
     */
    public function add(Point $point);

    /**
     * @param Point $point
     * @return Point
     */
    public function save(Point $point);

    /**
     * @param Point $point
     * @return Point
     */
    public function remove(Point $point);

    /**
     * @return Point[]
     */
    public function all();

    /**
     * @param $idInternal
     * @param $idCustomer
     * @return Point
     */
    public function getByIdInternal($idInternal, $idCustomer);

    /**
     * @param $idCustomer
     * @return int
     */
    public function getMaxIdInternal($idCustomer);

    /**
     * @param $idFileCustomer
     * @return Point[]
     */
    public function getItemsByIdFileCustomer($idFileCustomer);

    /**
     * @param Point $point
     * @return Point
     */
    public function disable(Point $point);
}
