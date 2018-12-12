<?php
namespace app\repositories;

use app\dto\PointStatus;

/**
 * Interface PointStatusRepositoryInterface
 * @package app\repositories
 */
interface PointStatusRepositoryInterface
{
    /**
     * @param $id
     * @return PointStatus
     */
    public function get($id);

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     */
    public function add(PointStatus $pointStatus);

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     */
    public function save(PointStatus $pointStatus);

    /**
     * @param PointStatus $pointStatus
     * @return PointStatus
     */
    public function remove(PointStatus $pointStatus);

    /**
     * @return PointStatus[]
     */
    public function all();

    /**
     * @param $code
     * @return PointStatus
     */
    public function getByCode($code);
}
