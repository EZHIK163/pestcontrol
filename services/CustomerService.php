<?php
namespace app\services;

use app\dto\Contact;
use app\dto\Customer;
use app\dto\Disinfectant;
use app\dto\DisinfectantSelect;
use app\repositories\CustomerRepositoryInterface;
use yii\helpers\ArrayHelper;

/**
 * Class CustomerService
 * @package app\services
 */
class CustomerService
{
    /**
     * @var CustomerRepositoryInterface $repository
     */
    private $repository;

    /**
     * CustomerService constructor.
     * @param CustomerRepositoryInterface $repository
     */
    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return Customer
     */
    public function getCustomer($id)
    {
        $customer = $this->repository->get($id);

        return $customer;
    }

    /**
     * @return array
     */
    public function getCustomerForDropDownList()
    {
        $customers = $this->repository->all();
        foreach ($customers as &$customer) {
            $customer = $customer->toArray();
        }

        $array = ArrayHelper::map($customers, 'id', 'name');

        return $array;
    }

    /**
     * @param $idUserOwner
     * @return Customer
     */
    public function getCustomerByIdUser($idUserOwner)
    {
        $customer = $this->repository->getByIdUser($idUserOwner);
        return $customer;
    }

    /**
     * @param $idCustomer
     * @param $idUser
     */
    public function setIdUserOwner($idCustomer, $idUser)
    {
        $customers = $this->repository->all();

        foreach ($customers as $customer) {
            if ($customer->getIdUserOwner() == $idUser) {
                $customer->setIdUserOwner(null);
                $this->repository->save($customer);
            }
        }

        $customer = $this->repository->get($idCustomer);
        $customer->setIdUserOwner($idUser);
        $this->repository->save($customer);
    }

    /**
     * @return array
     */
    public function getCustomersWithDisinfectants()
    {
        $customers = $this->repository->all();
        $finishCustomers = [];
        foreach ($customers as $customer) {
            $nameDisinfectants = [];
            /**
             * @var Disinfectant $disinfectant
             */
            foreach ($customer->getDisinfectants() as $disinfectant) {
                $nameDisinfectants [] = $disinfectant->getDescription();
            }
            $strDisinfectants = implode(', ', $nameDisinfectants);
            $finishCustomers [] = [
                'id'            => $customer->getId(),
                'name'          => $customer->getName(),
                'disinfectants' => $strDisinfectants
            ];
        }
        return $finishCustomers;
    }

    /**
     * @return array
     */
    public function getCustomersForManager()
    {
        $customers = $this->repository->all();
        $finish_customers = [];
        foreach ($customers as &$customer) {
            if ($customer->getIdUserOwner() === null) {
                $nameOwner = '-';
            } else {
                //TODO Добавить UserRepository и взять оттуда название юзера
                $nameOwner = $customer->getIdUserOwner();
            }

            $contacts = $customer->getContacts();
            $finishContacts = [];

            foreach ($contacts as $contact) {
                $description = $contact->getName() . ' - ' . $contact->getEmail();
                if (!empty($contact->getPhone())) {
                    $description = $description. ' - ' . $contact->getPhone();
                }
                $finishContacts [] = $description;
            }
            $strContacts = implode(', ', $finishContacts);
            $finish_customers [] = [
                'id'            => $customer->getId(),
                'name_owner'    => $nameOwner,
                'name'          => $customer->getName(),
                'contacts'      => $strContacts
            ];
        }
        return $finish_customers;
    }

    /**
     * @param $id
     */
    public function deleteCustomer($id)
    {
        $customer = $this->getCustomer($id);

        $this->repository->remove($customer);
    }

    /**
     * @param $id
     * @return Disinfectant[]
     */
    public function getDisinfectantsCustomer($id)
    {
        $customer = $this->getCustomer($id);
        $disinfectants = $customer->getDisinfectants();

        return $disinfectants;
    }

    /**
     * @param $id
     * @param DisinfectantSelect[] $disinfectantSelects
     */
    public function setDisinfectantsCustomer($id, $disinfectantSelects)
    {
        $customer = $this->getCustomer($id);
        $existDisinfectants = $customer->getDisinfectants();
        foreach ($disinfectantSelects as $disinfectantSelect) {
            $existDisinfectant = null;
            foreach ($existDisinfectants as $disinfectantCustomer) {
                if ($disinfectantCustomer->getId() == $disinfectantSelect->getId()) {
                    $existDisinfectant = $disinfectantCustomer;
                    break;
                }
            }

            if ($disinfectantSelect->isSelect() == true) {
                if ($existDisinfectant === null) {
                    $existDisinfectants [] = (new Disinfectant())
                        ->setId($disinfectantSelect->getId());
                }
            } else {
                $existDisinfectant && $existDisinfectant->setIsActive(false);
            }
        }
        $customer->setDisinfectants($existDisinfectants);
        $this->repository->save($customer);
    }

    /**
     * @param $id
     * @param $name
     * @param $idOwner
     * @param $contacts
     */
    public function changeCustomer($id, $name, $idOwner, $contacts)
    {
        $customer = $this->getCustomer($id);
        $customer->setName($name)->setIdUserOwner($idOwner);

        $contactNewIndex = ArrayHelper::index($contacts, 'id');

        $contactNew = [];
        $existContacts = $customer->getContacts();
        foreach ($existContacts as $existContact) {
            if (isset($contactNewIndex[$existContact->getId()])) {
                $contactNew [] = (new Contact())
                    ->setId($existContact->getId())
                    ->setName($contactNewIndex[$existContact->getId()]['name'])
                    ->setEmail($contactNewIndex[$existContact->getId()]['email'])
                    ->setPhone($contactNewIndex[$existContact->getId()]['phone']);
            } else {
                $existContact->setIsActive(false);
                $contactNew [] = $existContact;
            }
        }

        $customer->setContacts($contactNew);

        $this->repository->save($customer);
    }

    /**
     * @param $name
     * @param $idOwner
     * @param $contacts
     */
    public function addCustomer($name, $idOwner, $contacts)
    {
        $preparedContacts = [];

        foreach ($contacts as $contact) {
            $preparedContacts [] = (new Contact())
                ->setName($contact['name'])
                ->setEmail($contact['email'])
                ->setPhone($contact['phone']);
        }

        $customer = (new Customer())
            ->setName($name)
            ->setIdUserOwner($idOwner)
            ->setContacts($preparedContacts);

        $this->repository->add($customer);
    }

    public function getIdCustomerByCode($code)
    {
        $customer = self::findOne(compact('code'));
        return $customer->id;
    }
}
