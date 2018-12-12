<?php
namespace app\repositories;

use app\dto\FileExtension;
use app\entities\FileExtensionRecord;
use app\exceptions\ExtensionNotFound;
use RuntimeException;

/**
 * Class ExtensionRepository
 * @package app\repositories
 */
class ExtensionRepository implements ExtensionRepositoryInterface
{
    /**
     * @param $id
     * @return FileExtension
     * @throws ExtensionNotFound
     */
    public function get($id)
    {
        /**
         * @var FileExtensionRecord $fileExtensionRecord
         */
        $fileExtensionRecord = $this->findOrFail($id);

        $fileExtension = $this->fillFileExtension($fileExtensionRecord);

        return $fileExtension;
    }

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     * @throws \Throwable
     */
    public function add(FileExtension $fileExtension)
    {
        $fileExtensionRecord = new FileExtensionRecord();

        $fileExtensionRecord = $this->fillFileExtensionRecord($fileExtensionRecord, $fileExtension);

        if (!$fileExtensionRecord->insert()) {
            throw new RuntimeException();
        }

        $fileExtension->setId($fileExtensionRecord->id);

        return $fileExtension;
    }

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(FileExtension $fileExtension)
    {
        /**
         * @var FileExtensionRecord $fileExtensionRecord
         */
        $fileExtensionRecord = $this->findOrFail($fileExtension->getId());

        $fileExtensionRecord = $this->fillFileExtensionRecord($fileExtensionRecord, $fileExtension);

        $fileExtensionRecord->update();

        return $fileExtension;
    }

    /**
     * @param FileExtension $fileExtension
     * @return FileExtension
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(FileExtension $fileExtension)
    {
        $fileExtensionRecord = $this->findOrFail($fileExtension->getId());

        $fileExtensionRecord->is_active = false;

        if (!$fileExtensionRecord->update()) {
            throw new \RuntimeException();
        }

        $fileExtension->setIsActive(false);

        return $fileExtension;
    }

    /**
     * @return FileExtension[]
     */
    public function all()
    {
        $fileExtensionRecords = FileExtensionRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $fileExtensions = [];
        /**
         * @var FileExtensionRecord $fileExtensionRecord
         */
        foreach ($fileExtensionRecords as $fileExtensionRecord) {
            $fileExtensions [] = $this->fillFileExtension($fileExtensionRecord);
        }

        return $fileExtensions;
    }

    /**
     * @param $id
     * @return FileExtensionRecord
     * @throws ExtensionNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var FileExtensionRecord $fileExtension
         */
        if (!($fileExtension = FileExtensionRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new ExtensionNotFound();
        }

        return $fileExtension;
    }

    /**
     * @param FileExtensionRecord $fileExtensionRecord
     * @return FileExtension
     */
    private function fillFileExtension($fileExtensionRecord)
    {
        $fileExtension = (new FileExtension())
            ->setId($fileExtensionRecord->id)
            ->setTypeCode($fileExtensionRecord->type->code)
            ->setTypeDescription($fileExtensionRecord->type->description)
            ->setDescription($fileExtensionRecord->description)
            ->setExtension($fileExtensionRecord->extension)
            ->setPathToFolder($fileExtensionRecord->type->path_to_folder)
            ->setTypeId($fileExtensionRecord->type->id);

        return $fileExtension;
    }

    /**
     * @param FileExtensionRecord $fileExtensionRecord
     * @param FileExtension $fileExtension
     * @return FileExtensionRecord
     */
    private function fillFileExtensionRecord($fileExtensionRecord, $fileExtension)
    {
        $fileExtensionRecord->description = $fileExtension->getDescription();
        $fileExtensionRecord->extension = $fileExtension->getExtension();
        $fileExtensionRecord->id_type = $fileExtension->getTypeId();

        return $fileExtensionRecord;
    }

    /**
     * @param string $extension
     * @return FileExtension
     * @throws ExtensionNotFound
     */
    public function getByExtension($extension)
    {
        /**
         * @var FileExtensionRecord $fileExtensionRecord
         */
        if (!($fileExtensionRecord = FileExtensionRecord::find()
            ->andWhere(['extension'     => $extension])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new ExtensionNotFound();
        }

        $fileExtension = $this->fillFileExtension($fileExtensionRecord);

        return $fileExtension;
    }
}
