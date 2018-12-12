<?php
namespace app\services;

use app\dto\Disinfector;
use app\repositories\DisinfectorRepositoryInterface;

/**
 * Class DisinfectorService
 * @package app\services
 */
class DisinfectorService
{
    private $repository;

    /**
     * DisinfectorService constructor.
     * @param DisinfectorRepositoryInterface $repository
     */
    public function __construct(DisinfectorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getAllForManager()
    {
        $disinfectors = $this->repository->all();

        foreach ($disinfectors as &$disinfector) {
            $disinfector = $disinfector->toArray();
        }

        return $disinfectors;
    }

    /**
     * @param Disinfector $disinfector
     */
    public function saveDisinfector($disinfector)
    {
        $this->repository->save($disinfector);
    }

    /**
     * @param $id
     * @return Disinfector
     */
    public function getDisinfector($id)
    {
        $disinfector = $this->repository->get($id);

        return $disinfector;
    }

    /**
     * @param $id
     */
    public function deleteDisinfector($id)
    {
        $disinfector = $this->repository->get($id);
        $this->repository->remove($disinfector);
    }
}
