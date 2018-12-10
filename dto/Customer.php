<?php
namespace app\dto;

/**
 * Class Customer
 * @package app\dto
 */
class Customer
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string
     */
    private $code;

    /**
     * @var Disinfectant[] $disinfectants
     */
    private $disinfectants;

    /**
     * @var int
     */
    private $idUserOwner;

    /**
     * @var Contact[]
     */
    private $contacts;

    public function __construct()
    {
        $this->contacts = [];
        $this->disinfectants = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Customer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdUserOwner()
    {
        return $this->idUserOwner;
    }

    /**
     * @param int $idUserOwner
     * @return Customer
     */
    public function setIdUserOwner($idUserOwner)
    {
        $this->idUserOwner = $idUserOwner;

        return $this;
    }

    /**
     * @return Disinfectant[]
     */
    public function getDisinfectants()
    {
        return $this->disinfectants;
    }

    /**
     * @param Disinfectant[] $disinfectants
     * @return Customer
     */
    public function setDisinfectants($disinfectants)
    {
        $this->disinfectants = $disinfectants;

        return $this;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param Contact[] $contacts
     * @return Customer
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Customer
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $disinfectantsArray = [];
        foreach ($this->disinfectants as $disinfectant) {
            $disinfectantsArray [] = $disinfectant->toArray();
        }

        $contactsArray = [];
        foreach ($this->contacts as $contact) {
            $contactsArray [] = $contact->toArray();
        }

        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'code'              => $this->code,
            'disinfectants'     => $disinfectantsArray,
            'contacts'          => $contactsArray
        ];
    }

}
