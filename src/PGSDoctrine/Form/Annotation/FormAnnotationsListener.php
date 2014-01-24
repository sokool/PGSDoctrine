<?php

namespace PGSDoctrine\Form\Annotation;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Form\Annotation\ComposedObject;

class FormAnnotationsListener implements ListenerAggregateInterface
{

    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * Detach listeners
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if (false !== $events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * Attach listeners
     *
     * @param  EventManagerInterface $events
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('configureForm', array($this, 'setUpDoctrineHydrator'));
        $this->listeners[] = $events->attach('configureElement', array($this, 'handleComposedObjectAnnotation'));
    }

    public function setUpDoctrineHydrator($e)
    {
        $annotation = $e->getParam('annotation');
        if (!$annotation instanceof \Zend\Form\Annotation\Name)
            return;

        $formSpec = $e->getParam('formSpec');

        $entity = $e->getTarget()->getEntity();

        $formSpec['hydrator'] = new \ArrayObject([
            'type' => 'DoctrineModule\Stdlib\Hydrator\DoctrineObject',
            'target_class' => is_object($entity) ? get_class($entity) : $entity,
        ]);
    }

    public function handleComposedObjectAnnotation($e)
    {
        $annotation = $e->getParam('annotation');
        if (!$annotation instanceof ComposedObject) {
            return;
        }
//        $v = $annotation->getComposedObject();
//
//        if(!empty($v)) {
//            return;
//        }
//        $entity = $e->getTarget()->getEntity();
//
//        $annotation = new ComposedObject(['value' => is_object($entity) ? get_class($entity) : $entity]);
//        $e->setParam('annotation',$annotation);
//        var_dump($annotation);

        $entity = $e->getTarget()->getEntity();
        $class = is_object($entity) ? get_class($entity) : $entity;
        $annotationManager = $e->getTarget();
        $specification = $annotationManager->getFormSpecification($class);

        $name = $e->getParam('name');
        $elementSpec = $e->getParam('elementSpec');
        $filterSpec = $e->getParam('filterSpec');

        // Compose input filter into parent input filter
        $inputFilter = $specification['input_filter'];
        if (!isset($inputFilter['type'])) {
            $inputFilter['type'] = 'Zend\InputFilter\InputFilter';
        }
        $e->setParam('inputSpec', $inputFilter);
        unset($specification['input_filter']);

        // Compose specification as a fieldset into parent form/fieldset
        if (!isset($specification['type'])) {
            $specification['type'] = 'Zend\Form\Fieldset';
        }

        return;
        if ($annotation->isCollection()) {
            $elementSpec['spec']['type'] = 'Zend\Form\Element\Collection';
            $elementSpec['spec']['name'] = $name;
            $elementSpec['spec']['options'] = new ArrayObject($annotation->getOptions());
            $elementSpec['spec']['options']['target_element'] = $specification;

            if (isset($specification['hydrator'])) {
                $elementSpec['spec']['hydrator'] = $specification['hydrator'];
            }
        } else {
            $elementSpec['spec'] = $specification;
            $elementSpec['spec']['name'] = $name;
        }
    }

}
