<?php

namespace PGSDoctrine\Entity;

use Zend\Form\Annotation as Form;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("address")
 * @Form\Hydrator("DoctrineModule\Stdlib\Hydrator\DoctrineObject")
 * 
 * @ORM\Entity()
 * @ORM\Table(name="address")
 */
class Address {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @Form\Exclude() 
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true, name="line_one")
     * 
     * @Form\Attributes({"type":"text" })
     * @Form\Options({"label":"Line 1:"})
     */
    protected $line1;

    /**
     * @ORM\Column(type="string", nullable=true, name="line_two") 
     * 
     * @Form\Attributes({"type":"text" })
     * @Form\Options({"label":"Line 2:"})
     */
    protected $line2;

    /**
     * @ORM\Column(type="string", nullable=false, name="city")
     *  
     * @Form\Attributes({"type":"text" })
     * @Form\Options({"label":"City:"})
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=false, name="post_code") 
     * 
     * @Form\Attributes({"type":"text" })
     * @Form\Options({"label":"Post Code/Zip:"})
     */
    protected $postcode;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLine1() {
        return $this->line1;
    }

    public function setLine1($line1) {
        $this->line1 = $line1;
    }

    public function getLine2() {
        return $this->line2;
    }

    public function setLine2($line2) {
        $this->line2 = $line2;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getPostcode() {
        return $this->postcode;
    }

    public function setPostcode($postcode) {
        $this->postcode = $postcode;
    }

}

?>
