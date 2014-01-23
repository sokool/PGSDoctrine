<?php

return [
    'factories' => [
        'MintSoft\FormBakery\ModuleOptions' => 'PGSDoctrine\Form\Bakery\OptionsFactory',
        'MintSoft\FormBakery' => 'PGSDoctrine\Form\BakeryFactory'
    ],
    'shared' => [
        'MintSoft\FormBakery' => false,
    ]
];