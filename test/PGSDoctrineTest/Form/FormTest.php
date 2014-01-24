<?php

namespace PGSDoctrineTest\Form;

use Doctrine\Common\Annotations\Annotation;
use Doctrine\Common\Util\Debug;
use PGSDoctrine\Form\Annotation\AnnotationBuilder as PGSAnnotationBuilder;
use PGSDoctrineTest\Assets\Entity\Address;
use PGSDoctrineTest\Assets\Entity\Company;
use PGSDoctrineTest\Assets\Entity\Contact;
use PGSDoctrineTest\Assets\Entity\Person;
use PGSDoctrineTest\Bootstrap;
use Zend\Form\View\Helper\FormRow;
use Zend\Stdlib\ArrayObject;

class FormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PGSDoctrine\Form\Bakery\Service
     */
    protected function getBakery()
    {
        return Bootstrap::getServiceManager()->get('MintSoft\Form\Bakery');
    }

    public function testFormBaked()
    {
        $personForm = $this
            ->getBakery()
            ->bake(new Person());

        $this->assertInstanceOf('Zend\Form\Form', $personForm);
        $this->assertInstanceOf('Zend\Form\Element\Text', $personForm->get('username'));
        $this->assertInstanceOf('Zend\Form\Element\Email', $personForm->get('email'));
        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $personForm->getHydrator());
        $this->assertNull($personForm->getObject());

    }


    public function testObjectIsBound()
    {
        $personEntity = new Person();
        $personForm = $this
            ->getBakery()
            ->bake($personEntity, true);

        $this->assertSame($personForm->getObject(), $personEntity);
    }

    public function testBakedFormElementsHasBoundValues()
    {
        $personEntity = (new Person())
            ->setUsername('Beshtak')
            ->setEmail('beshtak@yahoo.com');

        $personForm = $this
            ->getBakery()
            ->bake($personEntity, true);

        $this->assertSame($personEntity->getUsername(), $personForm->get('username')->getValue());
        $this->assertSame($personEntity->getEmail(), $personForm->get('email')->getValue());

    }

    public function testOneBakedAgregation()
    {
        $personEntity = new Person();

        $personForm = $this
            ->getBakery()
            ->bake($personEntity);

        $addressFieldset = $personForm->get('address');

        $this->assertInstanceOf('\Zend\Form\Fieldset', $addressFieldset);
        $this->assertInstanceOf('DoctrineModule\Stdlib\Hydrator\DoctrineObject', $addressFieldset->getHydrator());
        $this->assertInstanceOf('Zend\Form\Element\Text', $addressFieldset->get('streetName'));
        $this->assertInstanceOf('Zend\Form\Element\Text', $addressFieldset->get('houseNumber'));
        $this->assertInstanceOf('Zend\Form\Element\Hidden', $addressFieldset->get('latitude'));
        $this->assertNull($addressFieldset->getObject());

    }

    public function testAgregatedObjectIsBound()
    {

        $personEntity = (new Person())
            ->setUsername('Kolosz')
            ->setCompany(
                (new Company())
                    ->setName('MintSoftware')
                    ->setAddress(
                        (new Address())
                            ->setCityName('Grudziądz')
                    )
            )
            ->setAddress(new Address());

//        $personForm = $this
//            ->getBakery()
//            ->bake($personEntity, true);

//
//        //Debug::dump($personForm->get('contacts'));
//        //exit;
//        $this->assertNull($personForm->get('address')->getObject());
        //var_dump($personEntity);
        //exit;
        //$a = microtime(true);
        $personForm = $this
            ->getBakery()
            ->bake($personEntity, [
                'address' => true,
                'company' => [
                    'address' => true
                ],
                'contact' => [
                    'address' => true
                ]
            ]);
        //$b = microtime(true);
//
//        echo $b - $a . PHP_EOL;
//
//        echo 'Person Elements: ';
//        print_r(array_keys($personForm->getElements()));
//        echo 'Person fieldsets: ';
//        print_r(array_keys($personForm->getFieldsets()));
//
//        echo 'PersonAddress fieldsets: ';
//        print_r(array_keys($personForm->get('address')->getFieldsets()));
//        echo 'PersonAddress Elements: ';
//        print_r(array_keys($personForm->get('address')->getElements()));
//
//
//        echo 'PersonCompany fieldsets: ';
//        print_r(array_keys($personForm->get('company')->getFieldsets()));
//        echo 'PersonCompany Elements: ';
//        print_r(array_keys($personForm->get('company')->getElements()));
//
//        echo 'PersonCompanyAddress fieldsets: ';
//        print_r(array_keys($personForm->get('company')->get('address')->getFieldsets()));
//        echo 'PersonCompanyAddress Elements: ';
//        print_r(array_keys($personForm->get('company')->get('address')->getElements()));
//
//        echo 'PersonContacts fieldsets: ';
//        print_r(array_keys($personForm->get('contacts')->getFieldsets()));
//        echo 'PersonContacts Elements: ';
//        print_r(array_keys($personForm->get('contacts')->getElements()));
//
//
//        exit;
        $personForm->prepare();
        $personForm->setData([
            'username' => 'Beshtak',
            'email' => 'dood@o2.pl',
            'company' => [
                'name' => 'PiGiEz',
                'address' => [
                    'cityName' => 'Wrocław'
                ]

            ]

        ]);

        //var_dump($personForm->getMessages());
        $personForm->isValid();
        //Debug::dump($personForm->getData(), 3);
        var_dump($personForm->get('company')->get('address')->get('cityName'));
        //exit;
        $this->assertSame($personEntity, $personForm->getObject());
        $this->assertSame($personEntity->getAddress(), $personForm->get('address')->getObject());


    }
//
//        $entity = new Person();
//        $entity->setEmail('marian.soko@onet.de');
//        $adres = new Address();
//        $adres->setCityName('Wrocław');
//
//        $entity->setAddress($adres);
//
//        $a = microtime(true);
//        $formBakery = Bootstrap::getServiceManager()->get('MintSoft\Form\Bakery');
//
//        $form = $formBakery->bake($entity, ['address' => ['cars']]);
//        //$form = $formBakery->bake(new Person());
//        $b = microtime(true);
//        echo $b - $a;

    //var_dump($form->getObject());
    //var_dump($form->get('email')->getValue());
    //var_dump($form->get('address')->get('cityName')->getValue());
    //exit;
    //$this->assertTrue($a === $b);
    //}
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
