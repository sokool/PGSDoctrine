<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 21/01/14
 * Time: 16:50
 */

namespace PGSDoctrineTest\Form;


use PGSDoctrine\Form\Factory;
use PGSDoctrineTest\Bootstrap;

class FormFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testIsImplementingObjectManagerAwareInterface() {
        $this->assertInstanceOf('DoctrineModule\Persistence\ObjectManagerAwareInterface', new Factory());
    }

    public function testA() {
        //$entityManager = Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager');
    }
} 