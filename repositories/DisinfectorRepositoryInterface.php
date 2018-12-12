<?php
namespace app\repositories;

use app\dto\Disinfector;

/**
 * Interface DisinfectorRepositoryInterface
 * @package app\repositories
 */
interface DisinfectorRepositoryInterface
{
    /**
     * @param $id
     * @return Disinfector
     */
    public function get($id);

    /**
     * @param Disinfector $disinfector
     * @return Disinfector
     */
    public function add(Disinfector $disinfector);

    /**
     * @param Disinfector $disinfector
     * @return Disinfector
     */
    public function save(Disinfector $disinfector);

    /**
     * @param Disinfector $disinfector
     * @return Disinfector
     */
    public function remove(Disinfector $disinfector);

    /**
     * @return Disinfector[]
     */
    public function all();
}
