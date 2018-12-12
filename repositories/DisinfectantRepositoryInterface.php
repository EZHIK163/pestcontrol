<?php
namespace app\repositories;

use app\dto\Disinfectant;

/**
 * Interface DisinfectantRepositoryInterface
 * @package app\repositories
 */
interface DisinfectantRepositoryInterface
{
    /**
     * @param $id
     * @return Disinfectant
     */
    public function get($id);

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     */
    public function add(Disinfectant $disinfectant);

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     */
    public function save(Disinfectant $disinfectant);

    /**
     * @param Disinfectant $disinfectant
     * @return Disinfectant
     */
    public function remove(Disinfectant $disinfectant);

    /**
     * @return Disinfectant[]
     */
    public function all();
}
