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
use Zend\Form\Fieldset as ZendFieldset;

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

    protected function bindOnBake(ZendFieldset $fieldset, $entity, array $binding)
    {
        if (is_object($entity)) {
            //print_r(get_class($entity));
            //print_r($binding);
            foreach ($binding as $bindName => $bindValue) {
                $agregatedFieldset = $fieldset->has($bindName) ? $fieldset->get($bindName) : null;

                if ($agregatedFieldset === null) {
                    continue;
                }


                // Dopisać obśługę w głąb.
                if (is_object($bindValue)) {
                    $agregatedFieldset->setObject($bindValue);
                } else {
                    $methods = get_class_methods($entity);
                    $getter = 'get' . ucfirst($bindName);
                    if (!in_array($getter, $methods)) {
                        throw new \Exception('nie ma metody');
                    }
                    $agregatedFieldset->setObject($entity->{$getter}());
                }
            }
        }

    }

    /**
     * @param object $entity
     * @return \Zend\Form\Form
     */
    public function bake($entity, $binding = null)
    {
        $form = $this
            ->getAnnotationBuilder()
            ->createForm($entity);

        if (!is_null($binding)) {
            $binding = !is_array($binding) ? [] : $binding;
            $this->bindOnBake($form, $entity, $binding);
            $form->bind($entity);
        }

        return $form;
    }

} 