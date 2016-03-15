<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\ResourceModel;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Component extends AbstractDb
{
    const MAIN_TABLE = 'dynamic_component_registry_component';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(static::MAIN_TABLE, ComponentInterface::COMPONENT_ID);
    }
}
