<?php

namespace PGSDoctrine\Entity;

use Zend\Form\Annotation as Form;
use PGSDoctrine\Form\Annotation as PGSForm;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("person")
 * @Form\Hydrator("DoctrineModule\Stdlib\Hydrator\DoctrineObject")
 * 
 * @ORM\Entity()
 * @ORM\Table(name="persons")
 */
class Person {

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
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Username:"})
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
     * @ORM\OneToOne(targetEntity="PGSDoctrine\Entity\Address", cascade={"persist"})
     * 
     * @Form\ComposedObject("PGSDoctrine\Entity\Address")
     */
    protected $address;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

}

?>