<?php

namespace PGSDoctrine\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ViewModel;

class View extends AbstractPlugin {

    /**
     * Render ViewModel with given template name.
     *
     * @param \Zend\View\Model\ViewModel|string $name
     * @param array $params model parameters
     * @return string Html rendered template
     */
    public function render($name, array $params = array()) {
        if ($name instanceof ViewModel) {
            $view = $name;
        } else {
            $view = new ViewModel($params);
            $view->setTerminal(true);
            $view->setTemplate($name);
        }
        return $this->getController()->getServiceLocator()->get('ViewRenderer')->render($view);
    }

    public function model($templateName = null, array $params = array()) {
        return (new ViewModel($params))
                        ->setTemplate($templateName);
    }

}
