<?php

namespace ZFbase\Notices;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controller_plugins' => [
        'aliases' => [
            'notices' => Controller\Plugin\Notices::class,
            'Notices' => Controller\Plugin\Notices::class,
        ],
        'factories' => [
            Controller\Plugin\Notices::class => InvokableFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'notices' => View\Helper\Notices::class,
            'Notices' => View\Helper\Notices::class,
        ],
        'factories' => [
            View\Helper\Notices::class => View\Helper\NoticesFactory::class,
        ],
    ],
    'view_helper_config' => [
        'notices' => [
            /*
             * Example settings:
             */
            //'auto_escape' => true,
            //'template_string' => '<div class="alert alert-{class} alert-dismissible" role="alert">{text}</div>',
            //'label_for_status' => [
            //    Message::CLASS_SUCCESS => 'Успешно:',
            //    Message::CLASS_INFO => 'Информация:',
            //    Message::CLASS_WARNING => 'Предупреждение:',
            //    Message::CLASS_ERROR => 'Ошибка:',
            //],
        ],
    ],
];
