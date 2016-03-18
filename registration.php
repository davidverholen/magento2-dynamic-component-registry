<?php
use DavidVerholen\DynamicComponentRegistry\Model\DynamicComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'DavidVerholen_DynamicComponentRegistry',
    __DIR__
);

DynamicComponentRegistrar::getInstance()->registerDynamicComponents();

