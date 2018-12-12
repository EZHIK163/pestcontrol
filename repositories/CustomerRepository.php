<?php
namespace app\repositories;

use app\dto\Contact;
use app\dto\Customer;
use app\dto\Disinfectant;
use app\entities\CustomerContactRecord;
use app\entities\CustomerDisinfectantRecord;
use app\entities\CustomerRecord;
use app\exceptions\CustomerNotFound;
use RuntimeException;

/**
 * Class CustomerRepository
 * @package app\repositories
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    private $disinfectantRepository;

    /**
     * CustomerRepository constructor.
     * @param DisinfectantRepositoryInterface $disinfectantRepository
     */
    public function __construct(DisinfectantRepositoryInterface $disinfectantRepository)
    {
        $this->disinfectantRepository = $disinfectantRepository;
    }

    /**
     * @param $id
     * @return Customer
     * @throws CustomerNotFound
     */
    public function get($id)
    {
        /**
         * @var CustomerRecord $customerRecord
         */
        $customerRecord = $this->findOrFail($id);

        $customer = $this->fillCustomer($customerRecord);

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws \Throwable
     */
    public function add(Customer $customer)
    {
        $customerRecord = new CustomerRecord();

        $customerRecord = $this->fillCustomerRecord($customerRecord, $customer);

        if (!$customerRecord->insert()) {
            throw new RuntimeException();
        }

        $customer->setId($customerRecord->id);

        $customer = $this->get($customer->getId());

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws CustomerNotFound
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Customer $customer)
    {
        /**
         * @var CustomerRecord $customerRecord
         */
        $customerRecord = $this->findOrFail($customer->getId());

        $customerRecord = $this->fillCustomerRecord($customerRecord, $customer);

        $customerRecord->update();

        $customer = $this->get($customer->getId());

        return $customer;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws CustomerNotFound
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Customer $customer)
    {
        $customerRecord = $this->findOrFail($customer->getId());

        $customerRecord->is_active = false;

        if (!$customerRecord->update()) {
            throw new RuntimeException();
        }

        return $customer;
    }

    /**
     * @return Customer[]
     */
    public function all()
    {
        $customerRecords = CustomerRecord::find()
            ->where(['is_active'    => true])
            ->orderBy('id ASC')
            ->all();

        $customers = [];
        /**
         * @var CustomerRecord $customerRecord
         */
        foreach ($customerRecords as $customerRecord) {
            $customers [] = $this->fillCustomer($customerRecord);
        }

        return $customers;
    }

    /**
     * @param $idUserOwner
     * @return Customer
     * @throws CustomerNotFound
     */
    public function getByIdUser($idUserOwner)
    {
        /**
         * @var CustomerRecord $customerRecord
         */
        if (!($customerRecord = CustomerRecord::find()
            ->andWhere(['is_active' => true])
            ->andWhere(['id_user_owner' => $idUserOwner])
            ->one())) {
            throw new CustomerNotFound();
        }

        $customer = $this->fillCustomer($customerRecord);

        return $customer;
    }

    /**
     * @param $id
     * @return CustomerRecord
     * @throws CustomerNotFound
     */
    private function findOrFail($id)
    {
        /**
         * @var CustomerRecord $customer
         */
        if (!($customer = CustomerRecord::find()
            ->andWhere(['id' => $id])
            ->andWhere(['is_active'  => true])
            ->one())) {
            throw new CustomerNotFound();
        }

        return $customer;
    }

    /**
     * @param CustomerRecord $customerRecord
     * @return Customer
     */
    private function fillCustomer($customerRecord)
    {
        $disinfectantRecords = $customerRecord->disinfectants;

        $disinfectants = [];
        foreach ($disinfectantRecords as $disinfectantRecord) {
            $disinfectants [] = $this->disinfectantRepository->get($disinfectantRecord->id);
        }

        $userOwnerRecord = $customerRecord->owner;
        $idUserOwner = $userOwnerRecord === null ? null : $userOwnerRecord->id;

        $contactRecords = $customerRecord->contacts;
        $contacts = [];
        foreach ($contactRecords as $contactRecord) {
            $contacts [] = $this->fillContacts($contactRecord);
        }

        $customer = (new Customer())
            ->setId($customerRecord->id)
            ->setName($customerRecord->name)
            ->setIdUserOwner($idUserOwner)
            ->setDisinfectants($disinfectants)
            ->setContacts($contacts);

        return $customer;
    }

    /**
     * @param CustomerRecord $customerRecord
     * @param Customer $customer
     * @return mixed
     */
    private function fillCustomerRecord($customerRecord, $customer)
    {
        $customerRecord->name = $customer->getName();
        $customerRecord->id_user_owner = $customer->getIdUserOwner();
        $customerRecord->code = $customer->getCode();

        $disinfectants = $customer->getDisinfectants();

        foreach ($disinfectants as &$disinfectant) {
            if ($disinfectant->isActive() === true) {
                $this->fillAndSaveCustomerDisinfectantRecord($customer, $disinfectant);
            } else {
                $this->removeCustomerDisinfectantRecord($customer, $disinfectant);
                unset($disinfectant);
            }
        }

        $contacts = $customer->getContacts();

        foreach ($contacts as &$contact) {
            if ($contact->isActive() === true) {
                $this->fillAndSaveCustomerContactRecord($customer, $contact);
            } else {
                $this->removeCustomerContactRecord($contact);
                unset($contact);
            }
        }

        return $customerRecord;
    }

    /**
     * @param CustomerContactRecord $contactRecord
     * @return Contact
     */
    private function fillContacts($contactRecord)
    {
        if ($contactRecord === null) {
            return null;
        }

        $contacts = (new Contact())
            ->setId($contactRecord->id)
            ->setName($contactRecord->name)
            ->setPhone($contactRecord->phone)
            ->setEmail($contactRecord->email);

        return $contacts;
    }

    /**
     * @param Customer $customer
     * @param Disinfectant $disinfectant
     */
    private function fillAndSaveCustomerDisinfectantRecord($customer, $disinfectant)
    {
        $customerDisinfectant = CustomerDisinfectantRecord::findOne([
            'id_customer'       => $customer->getId(),
            'id_disinfectant'   => $disinfectant->getId()
        ]);

        if (!$customerDisinfectant) {
            $customerDisinfectant = new CustomerDisinfectantRecord();
        }

        $customerDisinfectant->id_customer = $customer->getId();
        $customerDisinfectant->id_disinfectant = $disinfectant->getId();
        $customerDisinfectant->is_active = true;

        if (!$customerDisinfectant->save()) {
            throw new RuntimeException();
        }
    }

    /**
     * @param Customer $customer
     * @param Contact $contact
     * @return Contact
     */
    private function fillAndSaveCustomerContactRecord($customer, $contact)
    {
        $contactRecord = CustomerContactRecord::findOne($contact->getId());

        if (!$contactRecord) {
            $contactRecord = new CustomerContactRecord();
        }

        $contactRecord->id_customer = $customer->getId();
        $contactRecord->name = $contact->getName();
        $contactRecord->phone = $contact->getPhone();
        $contactRecord->email = $contact->getEmail();

        if (!$contactRecord->save()) {
            throw new RuntimeException();
        }

        $contact->setId($contactRecord->id);

        return $contact;
    }

    /**
     * @param Customer $customer
     * @param Disinfectant $disinfectant
     */
    private function removeCustomerDisinfectantRecord($customer, $disinfectant)
    {
        $customerDisinfectant = CustomerDisinfectantRecord::findOne([
            'id_customer'       => $customer->getId(),
            'id_disinfectant'   => $disinfectant->getId()
        ]);

        $customerDisinfectant->is_active = false;

        $customerDisinfectant->save();
    }

    /**
     * @param Contact $contact
     */
    private function removeCustomerContactRecord($contact)
    {
        $customerDisinfectant = CustomerContactRecord::findOne($contact->getId());

        $customerDisinfectant->is_active = false;

        $customerDisinfectant->save();
    }

    /**
     * @param $code
     * @return Customer
     */
    public function getByByCode($code)
    {
        $customerRecord = CustomerRecord::findOne(compact('code'));

        $customer = $this->fillCustomer($customerRecord);

        return $customer;
    }
}
