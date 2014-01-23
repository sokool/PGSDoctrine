<?php

namespace PGSDoctrine\Form\Annotation;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;

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
        $this->listeners[] = $events->attach('configureForm', array($this, 'handleHydratorAnnotation'));
    }

    public function handleHydratorAnnotation($e)
    {
        $annotation = $e->getParam('annotation');
        if (!$annotation instanceof \Zend\Form\Annotation\Hydrator)
            return;

        $formSpec = $e->getParam('formSpec');

        $entity = $e->getTarget()->getEntity();

        $formSpec['hydrator'] =  new \ArrayObject([
            'type' => $annotation->getHydrator(),
            'target_class' => is_object($entity) ? get_class($entity) : $entity,
        ]);
    }
}
