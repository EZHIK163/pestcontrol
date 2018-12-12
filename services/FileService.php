<?php
namespace app\services;

use app\dto\File;
use app\repositories\ExtensionRepositoryInterface;
use app\repositories\FileCustomerRepository;
use app\repositories\FileCustomerRepositoryInterface;
use app\repositories\FileRepositoryInterface;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class FileService
 * @package app\services
 */
class FileService
{
    private $fileRepository;
    private $extensionRepository;
    private $fileCustomerService;
    private $fileCustomerRepository;

    /**
     * FileService constructor.
     * @param FileRepositoryInterface $fileRepository
     * @param ExtensionRepositoryInterface $extensionRepository
     * @param FileCustomerService $fileCustomerService
     * @param FileCustomerRepository $fileCustomerRepository
     */
    public function __construct(
        FileRepositoryInterface $fileRepository,
        ExtensionRepositoryInterface $extensionRepository,
        FileCustomerService $fileCustomerService,
        FileCustomerRepository $fileCustomerRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->extensionRepository = $extensionRepository;
        $this->fileCustomerService = $fileCustomerService;
        $this->fileCustomerRepository = $fileCustomerRepository;
    }

    /**
     * @param UploadedFile[] $uploadedFiles
     * @param $idCustomer
     * @param $idFileCustomerType
     * @return bool
     */
    public function saveFilesFromUpload($uploadedFiles, $idCustomer, $idFileCustomerType)
    {
        foreach ($uploadedFiles as $uploadedFile) {
            $extension = $this->extensionRepository->getByExtension($uploadedFile->extension);

            $folder = $extension->getPathToFolder();

            $hash = md5(microtime() . $uploadedFile->baseName . $uploadedFile->extension);

            $file = (new File())
                ->setSize($uploadedFile->size)
                ->setOriginalName($uploadedFile->baseName)
                ->setHash($hash)
                ->setMimeType($uploadedFile->type)
                ->setExtension($extension);

            $file = $this->fileRepository->add($file);

            $this->fileCustomerService->addFileCustomer($file->getId(), $idCustomer, $uploadedFile->baseName, $idFileCustomerType);

            $rootPath = $this->getRootPath();

            if (!file_exists($rootPath . $folder)) {
                mkdir($rootPath. $folder, 0777);
            }

            $uploadedFile->saveAs($rootPath . $folder . $hash . '.' . $uploadedFile->extension);
        }
        return true;
    }

    /**
     * @return array
     */
    public function getSupportExtensions()
    {
        $extensions = $this->extensionRepository->all();
        $ext = [];
        foreach ($extensions as $support_extension) {
            $ext [] = $support_extension->getExtension();
        }
        return $ext;
    }

    /**
     * @return string
     */
    public function getRootPath()
    {
        return 'uploads/';
    }

    /**
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function getInfoForDownloadById($id)
    {
        $file = $this->fileRepository->get($id);

        if (!$file) {
            throw new NotFoundHttpException();
        }
        $url = $this->getRootPath().
            $file->getExtension()->getPathToFolder().
            $file->getHash().'.'.
            $file->getExtension()->getExtension();
        $name = $file->getOriginalName() . '.' . $file->getExtension()->getExtension();

        return compact('url', 'name');
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \app\exceptions\FileCustomerNotFound
     * @throws \yii\db\StaleObjectException
     */
    public function deleteFile($id)
    {
        $fileCustomer = $this->fileCustomerRepository->get($id);
        $this->fileCustomerRepository->remove($fileCustomer);
        $this->fileRepository->remove($fileCustomer->getFile());
    }
}
