<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'product' => 'Product\Controller\ProductController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../view',
//            'category' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'partial/productlist' => __DIR__ . '/../view/partial/productlist.phtml',
            'pagination_control' => __DIR__ . '/../view/partial/pagination_control.phtml',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'zh_CN',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => 'todo',
            ),
        ),
    ),
);
