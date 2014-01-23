<?php

namespace PGSDoctrineTest\Form;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Util\Debug;
use PGSDoctrine\Form\Annotation\AnnotationBuilder as PGSAnnotationBuilder;
use PGSDoctrine\Form\Annotation\FormAnnotationsListener;
use PGSDoctrine\Form\Factory;
use PGSDoctrineTest\Assets\Entity\Address;
use PGSDoctrineTest\Assets\Entity\Person;
use PGSDoctrineTest\Bootstrap;
use Zend\EventManager\Event;
use Zend\Form\Annotation\AllowEmpty;
use Zend\Form\Annotation\Hydrator;
use Zend\Stdlib\ArrayObject;

class FormTest extends \PHPUnit_Framework_TestCase
{
    public function testHasOne()
    {
        $entity = new Person();
        $form = (new PGSAnnotationBuilder(Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager')))->createForm($entity);
        $addressFieldset = $form->get('address');

        $this->assertInstanceOf('Zend\Form\Fieldset', $addressFieldset);
        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $addressFieldset->getHydrator());

    }

    public function testHasManyFieldset()
    {
        $entity = new Person();
        $entity->setEmail('marian.soko@onet.de');
        $adres = new Address();
        $adres->setCityName('Wrocław');

        $entity->setAddress($adres);


        $formBakery = Bootstrap::getServiceManager()->get('MintSoft\Form\Bakery');
        $form = $formBakery->bake($entity, [
            'address' => [
                'cars',
                'customers',
            ]
        ]);
        //$form = $formBakery->bake(new Person());


        var_dump($form->get('email')->getValue());
        var_dump($form->get('address')->get('cityName')->getValue());
        exit;
        $this->assertTrue($a === $b);
    }
//
//    public function testFormFactoryHasObjectManager() {
//        $entityManager = \PGSDoctrineTest\Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager');
//
//        $formFactory = new Factory();
//        $this->assertInstanceOf('\DoctrineModule\Persistence\ObjectManagerAwareInterface', $formFactory);
//
//        $formFactory->setObjectManager($entityManager);
//        $this->assertEquals($entityManager, $formFactory->getObjectManager());
//    }
//
//    public function testAnnotationBuilder()
//    {
//        $entityManager = \PGSDoctrineTest\Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager');
//
//        $annotationBuilder = new PGSAnnotationBuilder($entityManager);
//        $this->assertEquals($entityManager, $annotationBuilder->getEntityManager());
//
//
//        $annotationBuilder->createForm(new Person());
//
//
////new DoctrineObject();
//
////        $personEntity = new Person();
////        $personForm = (new PGSAnnotationBuilder($entityManager))->createForm($personEntity);
////
////        Debug::dump($personForm->get('address')->getHydrator());
////        exit;
//        //$personEntity = $entityManager->getReference('PGSDoctrine\Entity\Person', 1);
//
////        $personEntity = new \PGSDoctrine\Entity\Person();
////        $addressEntity = new \PGSDoctrine\Entity\Address;
////
////        $personEntity->setUsername('sokool');
////        $personEntity->setEmail('marian.sokolowski@gmail.com');
////        $personEntity->setAddress($addressEntity);
////        $addressEntity->setCity('Wrocław');
////        $addressEntity->setPostcode('54-117');
//
//        //print_r($personEntity);
////        $personForm = (new PGSAnnotationBuilder($entityManager))->createForm('\PGSDoctrine\Entity\Person');
////        /* @var $personForm \Zend\Form\Form */
////        $personForm->bind($personEntity);
////
////
////        $personForm->setValidationGroup(array(
////            'username', 'email'
////        ));
////        $personForm->setData(array(
////            'username' => 'michu',
////            'email' => 'msokolowski@pgs-soft.com',
////        ));
////        if ($personForm->isValid()) {
////
////            //print_r();
//////            $entityManager->persist($personEntity);
//////            $entityManager->flush($personEntity);
////           // print_r($personEntity);
////        } else {
////            print_r($personForm->getMessages());
////        }
//    }
//
//    public function testBla()
//    {
//        //$formPlugin = $this->form();
//        /** @var \PGSDoctrine\Mvc\Controller\Plugin\Form $formPlugin */
//
//        //$personForm = $formPlugin->bake($personEntity, ['address' => true]);
//    }

}
