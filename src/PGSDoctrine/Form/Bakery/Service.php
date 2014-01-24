<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 23/01/14
 * Time: 13:17
 */

namespace PGSDoctrine\Form\Bakery;

use PGSDoctrine\Form\Annotation\AnnotationBuilder as MintSoftAnnotationBuilder;
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
            $this->annotationBuilder = (new MintSoftAnnotationBuilder)
                ->setFormFactory($this->formFactory);
        }

        return $this->annotationBuilder;
    }

    protected function bindOnBake(ZendFieldset $fieldset, $entity, array $binding)
    {
        if (is_object($entity)) {
            foreach ($binding as $bindName => $bindValue) {
                //echo '----------------- ' . $bindName . ' ---------------'.PHP_EOL;
                $agregatedFieldset = $fieldset->has($bindName) ? $fieldset->get($bindName) : null;
                if ($agregatedFieldset === null) {
                    continue;
                }

                $methods = get_class_methods($entity);
                $getter = 'get' . ucfirst($bindName);
                if (!in_array($getter, $methods)) {
                    throw new \Exception('nie ma metody ' . get_class($entity) . '::' . $getter);
                }
                $agregatedObject = $entity->{$getter}();

//                echo 'Entity: ' . get_class($entity) . '::' . $getter . PHP_EOL;
//                echo 'Agregated Fieldset : ' . $agregatedFieldset->getName() . PHP_EOL;
//                echo 'Agregated Object : ' . get_class($agregatedObject) . PHP_EOL;
//                echo 'Binding array:' . print_r(@$binding[$bindName], true) . PHP_EOL;
                //echo $bindName . PHP_EOL;

                //print_r(get_class($entity)).PHP_EOL;

                // Dopisać obśługę w głąb.
                if (is_object($bindValue)) {
                    $agregatedFieldset->setObject($bindValue);
                } elseif (is_array($binding[$bindName])) {
                    $this->bindOnBake($agregatedFieldset, $agregatedObject, $binding[$bindName]);
                }

                if(is_object($agregatedObject)) {

                    $agregatedFieldset->setObject($agregatedObject);
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