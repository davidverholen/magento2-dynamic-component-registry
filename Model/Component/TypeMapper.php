<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\Component;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\Component\ComponentRegistrar;

class TypeMapper
{
    protected static $typeMap = [
        Component::TYPE_MODULE => ComponentRegistrar::MODULE,
        Component::TYPE_LANGUAGE => ComponentRegistrar::LANGUAGE,
        Component::TYPE_LIBRARY => ComponentRegistrar::LIBRARY,
        Component::TYPE_THEME => ComponentRegistrar::THEME
    ];

    /**
     * @param int $typeId
     *
     * @return string
     */
    public static function map($typeId = Component::TYPE_MODULE)
    {
        if (false === array_key_exists($typeId, static::$typeMap)) {
            return ComponentRegistrar::MODULE;
        }

        return static::$typeMap[$typeId];
    }
}
