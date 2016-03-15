<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component as ComponentResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Component::class, ComponentResource::class);
    }
}
