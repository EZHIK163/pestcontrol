<?php
namespace app\repositories;

use app\dto\FileExtension;

/**
 * Interface ExtensionRepositoryInterface
 * @package app\repositories
 */
interface ExtensionRepositoryInterface
{
    /**
     * @param $id
     * @return FileExtension
     */
    public function get($id);

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     */
    public function add(FileExtension $fileExtension);

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     */
    public function save(FileExtension $fileExtension);

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     */
    public function remove(FileExtension $fileExtension);

    /**
     * @return FileExtension[]
     */
    public function all();

    /**
     * @param string $extension
     * @return FileExtension
     */
    public function getByExtension($extension);
}
