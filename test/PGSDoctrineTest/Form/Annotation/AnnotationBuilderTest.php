<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 21/01/14
 * Time: 16:49
 */

namespace PGSDoctrineTest\Form\Annotation;


use PGSDoctrine\Form\Annotation\AnnotationBuilder as PGSAnnotationBuilder;
use PGSDoctrineTest\Assets\Entity\Address;
use PGSDoctrineTest\Bootstrap;

class AnnotationBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testHasEntity()
    {
        $entity = new Address();
        $annotationBuilder = new PGSAnnotationBuilder(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));
        $annotationBuilder->getFormSpecification($entity);


        $this->assertInstanceOf('PGSDoctrineTest\Assets\Entity\Address', $annotationBuilder->getEntity());
    }

    public function testHasTargetClass()
    {
        $entity = new Address();
        $annotationBuilder = new PGSAnnotationBuilder(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));
        $formSpec = $annotationBuilder->getFormSpecification($entity);

        $this->assertTrue($formSpec->offsetExists('hydrator'));
        $this->assertNotEmpty($formSpec['hydrator']['type']);
        $this->assertNotEmpty($formSpec['hydrator']['target_class']);
        $this->assertEquals('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $formSpec['hydrator']['type']);
        $this->assertEquals(get_class($entity), $formSpec['hydrator']['target_class']);
    }

    public function testCreateForm()
    {
        $entity = new Address();
        $form = (new PGSAnnotationBuilder(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')))->createForm($entity);

        $this->assertInstanceOf('Zend\Form\Form', $form);

    }

    public function testHasDoctrineHydrator()
    {
        $entity = new Address();
        $form = (new PGSAnnotationBuilder(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')))->createForm($entity);

        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $form->getHydrator());

    }

} 