<?php

namespace Notices;

use Zend\ServiceManager\Factory\InvokableFactory;

class Module
{
    public function getConfig()
    {
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
        ];
    }
}
