<?php

namespace PGSDoctrineTest\Form;

use PGSDoctrine\Form\Annotation\AnnotationBuilder as PGSAnnotationBuilder;

class FormTest extends \PHPUnit_Framework_TestCase {

    public function testHasInstance() {
        $entityManager = \PGSDoctrineTest\Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager');

        $personEntity = $entityManager->getReference('PGSDoctrine\Entity\Person', 1);
//        $personEntity = new \PGSDoctrine\Entity\Person();        
//        $addressEntity = new \PGSDoctrine\Entity\Address;
//
//        $personEntity->setUsername('sokool');
//        $personEntity->setEmail('marian.sokolowski@gmail.com');
//        $personEntity->setAddress($addressEntity);
//        $addressEntity->setCity('Wrocław');
//        $addressEntity->setPostcode('54-117');
        
        //print_r($personEntity);
        $personForm = (new PGSAnnotationBuilder($entityManager))->createForm('\PGSDoctrine\Entity\Person');
        /* @var $personForm \Zend\Form\Form */
        $personForm->bind($personEntity);
        
  
        $personForm->setValidationGroup(array(
            'username', 'email'
        ));
        $personForm->setData(array(
            'username' => 'michu',
            'email' => 'msokolowski@pgs-soft.com',
        ));
        if ($personForm->isValid()) {
  
            //print_r();
//            $entityManager->persist($personEntity);
//            $entityManager->flush($personEntity);
           // print_r($personEntity);
        } else {
            print_r($personForm->getMessages());
        }
    }

    public function testBla() {
        $formPlugin = $this->form();
        /** @var \PGSDoctrine\Mvc\Controller\Plugin\Form $formPlugin */

        $personForm = $formPlugin->bake($personEntity, ['address' => true]);
    }

}

?>
