<?php
namespace app\repositories;

use app\dto\Synchronize;
use app\dto\SynchronizeLast;

/**
 * Interface SynchronizeRepositoryInterface
 * @package app\repositories
 */
interface SynchronizeRepositoryInterface
{
    /**
     * @param $id
     * @return Synchronize
     */
    public function get($id);

    /**
     * @param Synchronize $sync
     * @return Synchronize
     */
    public function add(Synchronize $sync);

    /**
     * @param Synchronize $sync
     * @return Synchronize
     */
    public function save(Synchronize $sync);

    /**
     * @param Synchronize $sync
     * @return Synchronize
     */
    public function remove(Synchronize $sync);

    /**
     * @return Synchronize[]
     */
    public function all();

    /**
     * @return SynchronizeLast
     */
    public function getLastSynchronize();
}
