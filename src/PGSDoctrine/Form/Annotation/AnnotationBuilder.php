<?php

namespace PGSDoctrine\Form\Annotation;

use ArrayObject;
use Doctrine\Common\Util\Debug;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use PGSDoctrine\Form\Factory as PGSFormFactory;
use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Reflection\ClassReflection;
use Zend\Form\Exception;

class AnnotationBuilder extends DoctrineAnnotationBuilder
{

    public function setEventManager(\Zend\EventManager\EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $this->getEventManager()->attach(new FormAnnotationsListener);

        return $this;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function createForm($entity)
    {
        $this->setFormFactory(
            (new PGSFormFactory())
                ->setObjectManager($this->em)
        );

        return parent::createForm($entity);
    }

    public function getFormSpecification($entity)
    {
        $entityClass = (is_object($entity)) ? get_class($entity) : $entity;
        $specs = parent::getFormSpecification($entity);
//var_dump($specs);
//        if (array_key_exists('hydrator', $specs) && class_exists($specs['hydrator'])) {
//            $specs['hydrator'] = new ArrayObject([
//                'type' => $specs['hydrator'],
//                'target_class' => $entityClass,
//            ]);
//        }

        return $specs;
    }


}
