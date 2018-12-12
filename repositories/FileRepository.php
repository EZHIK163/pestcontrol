<?php
namespace app\repositories;

use app\dto\File;
use app\dto\FileExtension;
use app\entities\FileRecord;
use app\exceptions\FileNotFound;
use RuntimeException;

/**
 * Class FileRepository
 * @package app\repositories
 */
class FileRepository implements FileRepositoryInterface
{
    private $extensionRepository;

    /**
     * FileRepository constructor.
     * @param ExtensionRepositoryInterface $extensionRepository
     */
    public function __construct(ExtensionRepositoryInterface $extensionRepository)
    {
        $this->extensionRepository = $extensionRepository;
    }

    /**
     * @param $id
     * @return File
     * @throws FileNotFound
     */
    public function get($id)
    {
        /**
         * @var FileRecord $fileRecord
         */
        $fileRecord = $this->findOrFail($id);

        $file = $this->fillFile($fileRecord);

        return $file;
    }

    /**
     * @param File $file
     * @return File
     * @throws \Throwable
     */
    public function add(File $file)
    {
        $fileRecord = new FileRecord();

        $fileRecord = $this->fillFileRecord($fileRecord, $file);

        if (!$fileRecord->insert()) {
            throw new RuntimeException();
        }

        $file->setId($fileRecord->id);

        return $file;
    }

    /**
     * @param File $file
     * @return File
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(File $file)
    {
        /**
         * @var FileRecord $fileRecord
         */
        $fileRecord = $this->findOrFail($file->getId());

        $fileRecord = $this->fillFileRecord($fileRecord, $file);

        $fileRecord->update();

        return $file;
    }

    /**
     * @param File $file
     * @return File
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(File $file)
    {
        $fileRecord = $this->findOrFail($file->getId());

        $fileRecord->is_active = false;

        if (!$fileRecord->update()) {
            throw new \RuntimeException();
        }

        $file->setIsActive(false);

        return $file;
    }

    /**
     * @return File[]
     */
    public function all()
    {
        $fileRecords = FileRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $files = [];
        /**
         * @var FileRecord $fileRecord
         */
        foreach ($fileRecords as $fileRecord) {
            $files [] = $this->fillFile($fileRecord);
        }

        return $files;
    }

    /**
     * @param $id
     * @return FileRecord
     * @throws FileNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var FileRecord $file
         */
        if (!($file = FileRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new FileNotFound();
        }

        return $file;
    }

    /**
     * @param FileRecord $fileRecord
     * @return File
     */
    private function fillFile($fileRecord)
    {
        $extension = $this->extensionRepository->get($fileRecord->extension->id);

        $file = (new File())
            ->setId($fileRecord->id)
            ->setHash($fileRecord->hash)
            ->setOriginalName($fileRecord->original_name)
            ->setSize($fileRecord->size)
            ->setExtension($extension);

        return $file;
    }

    /**
     * @param FileRecord $fileRecord
     * @param File $file
     * @return FileRecord
     */
    private function fillFileRecord($fileRecord, $file)
    {
        $fileRecord->original_name = $file->getOriginalName();
        $fileRecord->hash = $file->getHash();
        $fileRecord->id_extension = $file->getExtension()->getId();
        $fileRecord->size = $file->getSize();

        return $fileRecord;
    }
}
