<?php

namespace ZFbase\Notices;

class Module
{
    const VERSION = '1.0-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
