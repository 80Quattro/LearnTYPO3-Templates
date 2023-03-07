<?php

/**
 * Extension Manager/Repository config file for ext "car_workshop_sitepackage".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'car workshop sitepackage',
    'description' => '',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'fluid_styled_content' => '11.5.0-11.5.99',
            'rte_ckeditor' => '11.5.0-11.5.99',
            'mask' => '',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Rjania\\CarWorkshopSitepackage\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Rafal Jania',
    'author_email' => 'rr.jania@gmail.com',
    'author_company' => 'rjania',
    'version' => '1.0.0',
];
