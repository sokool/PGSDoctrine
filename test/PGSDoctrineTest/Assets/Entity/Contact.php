<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 24/01/14
 * Time: 10:54
 */

namespace PGSDoctrineTest\Assets\Entity;

use Zend\Form\Annotation as Form;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("contact")
 *
 * @ORM\Entity()
 * @ORM\Table(name="contacts")
 */
class Contact
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
     * @ORM\ManyToOne(targetEntity="PGSDoctrineTest\Assets\Entity\Person", inversedBy="contacts")
     **/
    protected $person;

    /**
     * @ORM\OneToOne(targetEntity="PGSDoctrineTest\Assets\Entity\Address", cascade={"persist"})
     *
     * @Form\ComposedObject("PGSDoctrineTest\Assets\Entity\Address")
     */
    protected $address;

}