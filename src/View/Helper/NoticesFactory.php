<?php

namespace ZFbase\Notices\View\Helper;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class NoticesFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Notices
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new Notices;
        $plugin = $container->get('ControllerPluginManager')->get('Notices');

        $helper->setPluginNotices($plugin);

        $config = $container->get('config');
        if (isset($config['view_helper_config']['notices'])) {
            $configHelper = $config['view_helper_config']['notices'];

            if (isset($configHelper['auto_escape'])) {
                $helper->setAutoEscape($configHelper['auto_escape']);
            }

            if (isset($configHelper['template_string'])) {
                $helper->setMessageTemplateString($configHelper['template_string']);
            }

            if (isset($configHelper['label_for_status']) && is_array($configHelper['label_for_status'])) {
                foreach ($configHelper['label_for_status'] as $class => $label) {
                    $helper->setLabelByClass($class, $label);
                }
            }
        }

        return $helper;
    }
}
