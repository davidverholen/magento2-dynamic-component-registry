<?php
/**
 * DynamicComponentConfig.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Serializable;

use JMS\Serializer\Annotation as JMS;

/**
 * Class DynamicComponentConfig
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Serializable
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 *
 * @JMS\XmlRoot("dynamic_components_config")
 */
class DynamicComponentsConfig
{
    /**
     * @var ComponentConfig[]
     *
     * @JMS\SerializedName("components")
     * @JMS\Type("array<DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfig>")
     */
    protected $components = [];

    /**
     * addComponent
     *
     * @param ComponentConfig $componentConfig
     *
     * @return $this
     */
    public function addComponent(ComponentConfig $componentConfig)
    {
        $this->components[] = $componentConfig;
        return $this;
    }

    /**
     * @return ComponentConfig[]
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * @param ComponentConfig[] $components
     *
     * @return $this
     */
    public function setComponents($components)
    {
        $this->components = $components;
        return $this;
    }
}
