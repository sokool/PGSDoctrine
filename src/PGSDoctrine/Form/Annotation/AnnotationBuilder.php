<?php

namespace PGSDoctrine\Form\Annotation;

use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;
use PGSDoctrine\Form\Factory as PGSFormFactory;

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

}
