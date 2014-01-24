<?php

namespace PGSDoctrineTest\Assets\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation as Form;
use PGSDoctrine\Form\Annotation as PGSForm;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("person")
 *
 * @ORM\Entity()
 * @ORM\Table(name="persons")
 */
class Person
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Form\Exclude()
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false, name="username")
     *
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     * @Form\Validator({"name":"Regex", "options":{"pattern":"/^[a-zA-Z][a-zA-Z0-9_-]{0,24}$/"}})
     * @Form\Type("Text")
     * @Form\Options({"label":"Login:"})
     */
    protected $username;

    /**
     * @ORM\Column(type="string", nullable=false, name="email")
     *
     * @Form\Type("Zend\Form\Element\Email")
     * @Form\Options({"label":"Your email address:"})
     */
    protected $email;

    /**
     * @ORM\OneToOne(targetEntity="PGSDoctrineTest\Assets\Entity\Address", cascade={"persist"})
     *
     * @Form\ComposedObject("PGSDoctrineTest\Assets\Entity\Address")
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="PGSDoctrineTest\Assets\Entity\Company", inversedBy="persons")
     *
     * @Form\ComposedObject("PGSDoctrineTest\Assets\Entity\Company")
     **/
    protected $company;


    /**
     * @ORM\OneToMany(targetEntity="PGSDoctrineTest\Assets\Entity\Contact", mappedBy="person")
     *
     * @Form\ComposedObject("PGSDoctrineTest\Assets\Entity\Contact")
     **/
    protected $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * @param mixed $address
     * @return \PGSDoctrineTest\Assets\Entity\Person
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $email
     * @return \PGSDoctrineTest\Assets\Entity\Person
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $username
     * @return \PGSDoctrineTest\Assets\Entity\Person
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function addContact(Contact $contact)
    {
        $contact->setProduct($this);
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

}

?>