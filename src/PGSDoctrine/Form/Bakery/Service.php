<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 23/01/14
 * Time: 13:17
 */

namespace PGSDoctrine\Form\Bakery;

use PGSDoctrine\Form\Annotation\FormAnnotationsListener as FormHydratorAnnotationListener;
use Zend\Form\Annotation\AnnotationBuilder as ZendAnnotationBuilder;
use PGSDoctrine\Form\Factory as FormFactory;

class Service
{
    /**
     * @var \PGSDoctrine\Form\Factory
     */
    protected $formFactory;

    protected $annotationBuilder;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return \Zend\Form\Annotation\AnnotationBuilder
     */
    public function getAnnotationBuilder()
    {
        if (!$this->annotationBuilder) {
            $this->annotationBuilder = (new ZendAnnotationBuilder)
                ->setFormFactory($this->formFactory);

            $this->annotationBuilder
                ->getEventManager()
                ->attach(new FormHydratorAnnotationListener());
        }

        return $this->annotationBuilder;
    }


    /**
     * @param object $entity
     * @return \Zend\Form\Form
     */
    public function bake($entity)
    {
        return $this
            ->getAnnotationBuilder()
            ->createForm($entity);
    }

} 