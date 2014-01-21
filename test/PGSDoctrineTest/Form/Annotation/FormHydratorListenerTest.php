<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 21/01/14
 * Time: 16:49
 */

namespace PGSDoctrineTest\Form\Annotation;

use PGSDoctrine\Form\Annotation\AnnotationBuilder as PGSAnnotationBuilder;
use PGSDoctrine\Form\Annotation\FormAnnotationsListener;
use PGSDoctrineTest\Assets\Entity\Address;
use PGSDoctrineTest\Bootstrap;
use Zend\EventManager\Event;
use Zend\Form\Annotation\AllowEmpty;
use Zend\Form\Annotation\Hydrator;

class FormHydratorListenerTest extends \PHPUnit_Framework_TestCase
{
    private function getEvent()
    {
        $annotationBuilder = new PGSAnnotationBuilder(\PGSDoctrineTest\Bootstrap::getServiceManager()->get('Doctrine\ORM\EntityManager'));

        return (new Event())
            ->setParam('formSpec', new \ArrayObject())
            ->setParam('annotation', new Hydrator(['value' => 'DoctrineModule\Stdlib\Hydrator\DoctrineObject']))
            ->setTarget($annotationBuilder);
    }

    public function testWrongAnnotation()
    {

        $formAnnotationListener = new FormAnnotationsListener();
        $event = $this
            ->getEvent()
            ->setParam('annotation', new AllowEmpty(['value' => false]));

        $formSpec = $event->getParam('formSpec');

        $formAnnotationListener->handleHydratorAnnotation($event);
        $this->assertFalse($formSpec->offsetExists('hydrator'));

    }

    public function testGoodAnnotation()
    {

        $event = $this->getEvent();
        $formSpec = $event->getParam('formSpec');

        (new FormAnnotationsListener())->handleHydratorAnnotation($event);

        $this->assertTrue($formSpec->offsetExists('hydrator'));
        $this->assertNotEmpty($formSpec['hydrator']['type']);
        $this->assertEmpty($formSpec['hydrator']['target_class']);
    }

} 