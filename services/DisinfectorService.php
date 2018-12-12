<?php
namespace app\services;

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
}
