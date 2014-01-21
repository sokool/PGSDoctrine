<?php
namespace PGSDoctrine;

return array(
    'doctrine' => array(
        'driver' => array(
            'PGSDoctrineTest\Assets\Entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/PGSDoctrineTest/Assets/Entity'
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'PGSDoctrineTest\Assets\Entity' => 'PGSDoctrineTest\Assets\Entity',
                ),
            ),
        ),
    ),
);


