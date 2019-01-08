<?php
namespace app\services;

use app\dto\Disinfectant;
use app\repositories\DisinfectantRepositoryInterface;

/**
 * Class DisinfectantService
 * @package app\services
 */
class DisinfectantService
{
    private $repository;

    /**
     * DisinfectantService constructor.
     * @param DisinfectantRepositoryInterface $repository
     */
    public function __construct(DisinfectantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getDisinfectants()
    {
        $disinfectants = $this->repository->all();

        foreach ($disinfectants as &$disinfectant) {
            $disinfectant = $disinfectant->toArray();
        }

        return $disinfectants;
    }

    /**
     * @param $id
     * @return Disinfectant
     */
    public function getDisinfectant($id)
    {
        $disinfectant = $this->repository->get($id);
        return $disinfectant;
    }

    /**
     * @param $code
     * @return Disinfectant
     */
    public function getDisinfectantByCode($code)
    {
        $disinfectants = $this->repository->all();

        foreach ($disinfectants as $disinfectant) {
            if ($disinfectant->getCode() === $code) {
                return $disinfectant;
            }
        }
        return null;
    }

    /**
     * @param $id
     */
    public function deleteDisinfectant($id)
    {
        $disinfectant = $this->repository->get($id);
        $this->repository->remove($disinfectant);
    }

    /**
     * @param Disinfectant $disinfectant
     */
    public function saveDisinfectant($disinfectant)
    {
        $this->repository->save($disinfectant);
    }

    /**
     * @param Disinfectant $disinfectant
     */
    public function addDisinfectant($disinfectant)
    {
        $this->repository->add($disinfectant);
    }
}
