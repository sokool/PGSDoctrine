<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 23/01/14
 * Time: 13:00
 */

namespace PGSDoctrine\Form;

use PGSDoctrine\Form\Bakery\Service as BakeryService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class BakeryFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Configuration')['mintsoft_form_bakery'];
        $formFactory = (new Factory())
            ->setObjectManager($serviceLocator->get('Doctrine\ORM\EntityManager'))
            ->setFormElementManager($serviceLocator->get('FormElementManager'));


        return new BakeryService($formFactory);
    }
} 