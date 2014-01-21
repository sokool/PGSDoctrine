<?php

namespace PGSDoctrine\Mvc\Controller\Plugin;

use PGSDoctrine\Form\Annotation\AnnotationBuilder;
use Zend\Form\Fieldset as ZendFieldset;
use Zend\Form\Form as ZendForm;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Form extends AbstractPlugin
{

    public function validate(ZendForm $form, \Closure $onSuccess = null, \Closure $onFail = null)
    {

        $getMethodForm = $form->getAttribute('method') == 'get';
        if ($this->controller->getRequest()->isPost() || $getMethodForm) {
            $post = $this->controller->params()->fromPost();
            $files = $this->controller->params()->fromFiles();

            $data = array_merge_recursive($post, $files);
            if ($getMethodForm) {
                $data = array_merge_recursive($this->controller->getRequest()->getQuery()->toArray());
            } else {
                if (empty($data))
                    return false;
            }

            $form->setData($data);
            if ($form->isValid()) {
                if (!is_null($onSuccess))
                    $onSuccess($form, $data);

                return true;
            } else {
                if (!is_null($onFail))
                    $onFail($form, $data);

                return false;
            }
        }

        return false;
    }

    /**
     * @todo This method is not stable - not finished - buts it's solve some scenarios with baking form based on entity.
     *
     * @param  object   $entity
     * @param  array    $binding
     * @throws
     * @return ZendForm
     */
    public function bake($entity, $binding = [])
    {
        if (!is_object($entity)) {
            throw new \InvalidArgumentException(sprintf(
                    '%s expects an Doctrine2 entity object, received "%s"',
                    __METHOD__, gettype($entity))
            );
        }

        $doctrinePlugin = $this->getController()->doctrine();
        /* @var Doctrine $doctrinePlugin */

        $form = (new AnnotationBuilder($doctrinePlugin->em()))
            ->createForm($entity);

        if (!empty($binding) && is_object($entity)) {
            $form->setObject($entity);
            $this->bindOnBake($form, $binding);
            $form->bind($entity);
        }

        return $form;
    }

    /**
     * @todo This method is NOT STABLE - not finished - but it's solve some scenarios with baking form based on entity.
     *
     * @param ZendFieldset $fieldset
     * @param array        $binding
     */
    protected function bindOnBake(ZendFieldset $fieldset, array $binding)
    {
        $entity = $fieldset->getObject();
        if (is_object($entity)) {
            foreach ($binding as $bindName => $bindValue) {
                $agregatedFieldset = $fieldset->has($bindName) ? $fieldset->get($bindName) : null;
                if ($agregatedFieldset === null) {
                    continue;
                }

                if (is_object($bindValue)) {
                    $agregatedFieldset->setObject($bindValue);
                } elseif (is_array($bindValue) && !empty($bindValue)) {

                } else {
                    $agregatedFieldset->setObject($entity->{'get' . ucfirst($bindName)}());
                }
            }
        }

    }

}
