<?php
/**
 * Component.php
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
 * Class Component
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Serializable
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ComponentConfig
{
    /**
     * @var string
     *
     * @JMS\SerializedName("name")
     * @JMS\Type("string")
     */
    protected $name = '';

    /**
     * @var string
     *
     * @JMS\SerializedName("type")
     * @JMS\Type("string")
     */
    protected $type = '';

    /**
     * @var string
     *
     * @JMS\SerializedName("path")
     * @JMS\Type("string")
     */
    protected $path = '';

    /**
     * @var string
     *
     * @JMS\SerializedName("psr4_prefix")
     * @JMS\Type("string")
     */
    protected $psr4Prefix = '';

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPsr4Prefix()
    {
        return $this->psr4Prefix;
    }

    /**
     * @param string $psr4Prefix
     *
     * @return $this
     */
    public function setPsr4Prefix($psr4Prefix)
    {
        $this->psr4Prefix = $psr4Prefix;
        return $this;
    }
}
