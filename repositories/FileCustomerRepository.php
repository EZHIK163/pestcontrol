<?php
namespace app\repositories;

use app\dto\FileCustomer;
use app\dto\FileCustomerType;
use app\entities\FileCustomerRecord;
use app\entities\FileCustomerTypeRecord;
use app\exceptions\FileCustomerNotFound;
use DateTime;
use RuntimeException;

/**
 * Class FileCustomerRepository
 * @package app\repositories
 */
class FileCustomerRepository implements FileCustomerRepositoryInterface
{
    private $customerRepository;
    private $fileRepository;

    /**
     * FileCustomerRepository constructor.
     * @param CustomerRepositoryInterface $customerRepository
     * @param FileRepositoryInterface $fileRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        FileRepositoryInterface $fileRepository
    ) {
        $this->customerRepository = $customerRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * @param $id
     * @return FileCustomer
     * @throws FileCustomerNotFound
     */
    public function get($id)
    {
        /**
         * @var FileCustomerRecord $fileCustomerRecord
         */
        $fileCustomerRecord = $this->findOrFail($id);

        $fileCustomer = $this->fillFileCustomer($fileCustomerRecord);

        return $fileCustomer;
    }

    /**
     * @param FileCustomer $fileCustomer
     * @return FileCustomer
     * @throws \Throwable
     */
    public function add(FileCustomer $fileCustomer)
    {
        $fileCustomerRecord = new FileCustomerRecord();

        $fileCustomerRecord = $this->fillFileCustomerRecord($fileCustomerRecord, $fileCustomer);

        if (!$fileCustomerRecord->insert()) {
            throw new RuntimeException();
        }

        $fileCustomer->setId($fileCustomerRecord->id);

        return $fileCustomer;
    }

    /**
     * @param FileCustomer $fileCustomer
     * @return FileCustomer
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(FileCustomer $fileCustomer)
    {
        /**
         * @var FileCustomerRecord $fileCustomerRecord
         */
        $fileCustomerRecord = $this->findOrFail($fileCustomer->getId());

        $fileCustomerRecord = $this->fillFileCustomerRecord($fileCustomerRecord, $fileCustomer);

        $fileCustomerRecord->update();

        return $fileCustomer;
    }

    /**
     * @param FileCustomer $fileCustomer
     * @return FileCustomer
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(FileCustomer $fileCustomer)
    {
        $fileCustomerRecord = $this->findOrFail($fileCustomer->getId());

        $fileCustomerRecord->is_active = false;

        if (!$fileCustomerRecord->update()) {
            throw new \RuntimeException();
        }

        $fileCustomer->setIsActive(false);

        return $fileCustomer;
    }

    /**
     * @return FileCustomer[]
     */
    public function all()
    {
        $fileCustomerRecords = FileCustomerRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $fileCustomers = [];
        /**
         * @var FileCustomerRecord $fileCustomerRecord
         */
        foreach ($fileCustomerRecords as $fileCustomerRecord) {
            $fileCustomers [] = $this->fillFileCustomer($fileCustomerRecord);
        }

        return $fileCustomers;
    }

    /**
     * @param $id
     * @return FileCustomerRecord
     * @throws FileCustomerNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var FileCustomerRecord $fileCustomer
         */
        if (!($fileCustomer = FileCustomerRecord::find()
            ->andWhere(['id'            => $id])
            ->andWhere(['is_active'     => true])
            ->one())) {
            throw new FileCustomerNotFound();
        }

        return $fileCustomer;
    }

    /**
     * @param FileCustomerRecord $fileCustomerRecord
     * @return FileCustomer
     */
    private function fillFileCustomer($fileCustomerRecord)
    {
        $customer = $this->customerRepository->get($fileCustomerRecord->id_customer);

        $type = $fileCustomerRecord->fileCustomerType;

        $file = $this->fileRepository->get($fileCustomerRecord->id_file);

        $fileCustomer = (new FileCustomer())
            ->setId($fileCustomerRecord->id)
            ->setCustomer($customer)
            ->setTypeCode($type->code)
            ->setTypeDescription($type->description)
            ->setTypeId($type->id)
            ->setTitle($fileCustomerRecord->title)
            ->setCreatedAt(DateTime::createFromFormat('U', (string)$fileCustomerRecord->created_at))
            ->setFile($file);

        return $fileCustomer;
    }

    /**
     * @param FileCustomerRecord $fileCustomerRecord
     * @param FileCustomer $fileCustomer
     * @return FileCustomerRecord
     */
    private function fillFileCustomerRecord($fileCustomerRecord, $fileCustomer)
    {
        $fileCustomerRecord->title = $fileCustomer->getTitle();
        $fileCustomerRecord->id_customer = $fileCustomer->getCustomer()->getId();
        $fileCustomerRecord->id_file_customer_type = $fileCustomer->getTypeId();
        $fileCustomerRecord->id_file = $fileCustomer->getFile()->getId();

        return $fileCustomerRecord;
    }

    /**
     * @param $idFile
     * @return FileCustomer
     */
    public function getByIdFile($idFile)
    {
        $fileCustomerRecord = FileCustomerRecord::findOne(['id_file'   => $idFile]);

        $fileCustomer = $this->fillFileCustomer($fileCustomerRecord);

        return $fileCustomer;
    }

    /**
     * @param $code
     * @return FileCustomer[]
     */
    public function getItemsByTypeCode($code)
    {
        $fileCustomerRecords = FileCustomerRecord::find()
            ->join('inner join', 'file_customer_type', 'file_customer_type.id = file_customer.id_file_customer_type')
            ->where(['file_customer_type.is_active'    => true])
            ->andWhere(['file_customer.is_active'   => true])
            ->andWhere(['file_customer_type.code'   => $code])
            ->orderBy('id ASC')
            ->all();

        $fileCustomers = [];
        /**
         * @var FileCustomerRecord $fileCustomerRecord
         */
        foreach ($fileCustomerRecords as $fileCustomerRecord) {
            $fileCustomers [] = $this->fillFileCustomer($fileCustomerRecord);
        }

        return $fileCustomers;
    }

    /**
     * @return FileCustomerType[]
     */
    public function getTypes()
    {
        /**
         * @var FileCustomerTypeRecord[] $fileCustomerTypeRecords
         */
        $fileCustomerTypeRecords = FileCustomerTypeRecord::find()->all();

        $fileCustomerTypes = [];
        foreach ($fileCustomerTypeRecords as $fileCustomerTypeRecord) {
            $fileCustomerTypes [] = (new FileCustomerType())
                ->setDescription($fileCustomerTypeRecord->description)
                ->setCode($fileCustomerTypeRecord->code)
                ->setId($fileCustomerTypeRecord->id);
        }

        return $fileCustomerTypes;
    }

    /**
     * @param $id
     * @return FileCustomerType
     */
    public function getTypeById($id)
    {
        $fileCustomerTypeRecord = FileCustomerTypeRecord::findOne($id);

        $fileCustomerType = (new FileCustomerType())
            ->setDescription($fileCustomerTypeRecord->description)
            ->setCode($fileCustomerTypeRecord->code)
            ->setId($fileCustomerTypeRecord->id);

        return $fileCustomerType;
    }
}
