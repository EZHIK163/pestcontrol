<?php
namespace app\repositories;

use app\dto\File;

/**
 * Interface FileRepositoryInterface
 * @package app\repositories
 */
interface FileRepositoryInterface
{
    /**
     * @param $id
     * @return File
     */
    public function get($id);

    /**
     * @param File $file
     * @return File
     */
    public function add(File $file);

    /**
     * @param File $file
     * @return File
     */
    public function save(File $file);

    /**
     * @param File $file
     * @return File
     */
    public function remove(File $file);

    /**
     * @return File[]
     */
    public function all();
}
