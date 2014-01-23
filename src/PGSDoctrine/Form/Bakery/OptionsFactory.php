<?php
/**
 * Created by PhpStorm.
 * User: sokool
 * Date: 23/01/14
 * Time: 13:06
 */

namespace PGSDoctrine\Form\Bakery;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //$config = $serviceLocator->get('Configuration');
        //$config = isset($config['spiffy_routes']) ? $config['spiffy_routes'] : array();

        //return new ModuleOptions($config);
    }
} 