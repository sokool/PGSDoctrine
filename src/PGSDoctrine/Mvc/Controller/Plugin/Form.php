<?php

namespace PGSDoctrine\Mvc\Controller\Plugin;

use Company\Entity\Attachment;
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
     * @param object $entity
     * @param array $binding
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
     * @param Fieldset $fieldset
     * @param array $binding
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

    /**
     * @deprecated Please use \Application\Mvc\Controller\Plugin\Form::bake() method instead.
     *
     * @param $entityName
     * @param array $options
     * @return object|\Zend\Form\FieldsetInterface
     */
    public function create($entityName, array $options = array())
    {
        $serviceManager = $this->getController()->getServiceLocator();
        /* @var $serviceManager \Zend\ServiceManager\ServiceManager */

        $formElementManager = $serviceManager->get('FormElementManager');
        /* @var $formElementManager \Zend\Form\FormElementManager */

        $annotationBuilder = $serviceManager->get('DoctrineORMModule\Form\Annotation\AnnotationBuilder');
        /* @var $annotationBuilder \DoctrineORMModule\Form\Annotation\AnnotationBuilder */

        if (empty($options)) {
            return $formElementManager->get($entityName);
        }

        $form = $annotationBuilder
            ->createForm($entityName)
            ->setHydrator(new EntityHydrator($serviceManager->get('doctrine.entitymanager.orm_default'), $entityName));

        if (!empty($options) && key_exists('bind', $options) && is_object($options['bind']))
            $form->bind($options['bind']);

        return $form;
    }

    public function sendPasswordResetMail(\IlacUser\Entity\User $user, $newPassword)
    {

        $html = new \Zend\Mime\Part($this->getController()->renderTemplate('settings/password-reset-mail', array(
            'user' => $user,
            'newPassword' => $newPassword
        )));
        $html->type = 'text/html';

        $body = new \Zend\Mime\Message();
        $body->setParts(array($html));

        $msg = new \Zend\Mail\Message();
        $msg->addTo($user->getUsername());
        $msg->setSubject('ILAC new access');
        $msg->setFrom('robot@pgs-soft.com');
        $msg->setBody($body);

        $this->getController()->getServiceLocator()->get('Zend\Mail\Transport\Smtp')->send($msg);
    }

    public function fileUpload(Attachment $attachment)
    {
        return (new FormAnnotationBuilder)
            ->createForm($attachment)
            ->add(array('name' => 'submit', 'attributes' => array('value' => 'Upload image file')))
            ->bind($attachment)
            ->setValidationGroup(array('fileInfo'));
    }

}

?>
