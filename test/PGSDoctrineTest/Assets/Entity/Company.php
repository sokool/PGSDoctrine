<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 24/01/14
 * Time: 15:37
 */

namespace PGSDoctrineTest\Assets\Entity;

use Zend\Form\Annotation as Form;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("company")
 *
 * @ORM\Entity()
 * @ORM\Table(name="companies")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Form\Type("Hidden")
     *
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=true)
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"Name"})
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="PGSDoctrineTest\Assets\Entity\Address", cascade={"persist"})
     *
     * @Form\ComposedObject("PGSDoctrineTest\Assets\Entity\Address")
     */
    protected $address;

    /**
     * @ORM\OneToMany(targetEntity="PGSDoctrineTest\Assets\Entity\Person", mappedBy="company")
     */
    protected $persons;

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param mixed $address
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


} 