<?php

namespace DavidVerholen\DynamicComponentRegistry\Model;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use Magento\Framework\Model\AbstractModel;

class Component extends AbstractModel implements ComponentInterface
{
    protected $_eventPrefix = 'dynamic_component';

    protected $_eventObject = 'component';

    const TYPE_MODULE = 1;
    const TYPE_LIBRARY = 2;
    const TYPE_THEME = 3;
    const TYPE_LANGUAGE = 4;

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    protected function _construct()
    {
        $this->_init(ResourceModel\Component::class);
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return [
            static::TYPE_MODULE => __('Module'),
            static::TYPE_LIBRARY => __('Library'),
            static::TYPE_THEME => __('Theme'),
            static::TYPE_LANGUAGE => __('Language')
        ];
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [
            static::STATUS_DISABLED => __('Disabled'),
            static::STATUS_ENABLED => __('Enabled')
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(ComponentInterface::NAME);
    }

    /**
     * @return integer
     */
    public function getType()
    {
        return (int)$this->getData(ComponentInterface::TYPE);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->getData(ComponentInterface::PATH);
    }

    /**
     * @return string
     */
    public function getPsr4Prefix()
    {
        return $this->getData(ComponentInterface::PSR4_PREFIX);
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return (int)$this->getData(ComponentInterface::STATUS);
    }

    /**
     * @param $name
     *
     * @return ComponentInterface
     */
    public function setName($name)
    {
        return $this->setData(ComponentInterface::NAME, $name);
    }

    /**
     * @param $type
     *
     * @return ComponentInterface
     */
    public function setType($type)
    {
        return $this->setData(ComponentInterface::TYPE, $type);
    }

    /**
     * @param $path
     *
     * @return ComponentInterface
     */
    public function setPath($path)
    {
        return $this->setData(ComponentInterface::PATH, $path);
    }

    /**
     * @param $psr4Prefix
     *
     * @return ComponentInterface
     */
    public function setPsr4Prefix($psr4Prefix)
    {
        return $this->setData(ComponentInterface::PSR4_PREFIX, $psr4Prefix);
    }

    /**
     * @param $status
     *
     * @return ComponentInterface
     */
    public function setStatus($status)
    {
        return $this->setData(ComponentInterface::STATUS, $status);
    }
}
