<?php
/**
 * ConfigFactory.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Model\Serializable;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component\Collection;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component\CollectionFactory;
use DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfig;
use DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfigFactory;
use DavidVerholen\DynamicComponentRegistry\Serializable\DynamicComponentsConfig;
use DavidVerholen\DynamicComponentRegistry\Serializable\DynamicComponentsConfigFactory;
use Magento\Framework\Module\Status;

/**
 * Class ConfigFactory
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Model\Serializable
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ConfigFactory
{
    const CONFIG_FORMAT = 'json';
    const CONFIG_DIR = 'dynamic_components';
    const CONFIG_FILE_NAME = 'config.json';

    /**
     * @var CollectionFactory
     */
    protected $componentCollectionFactory;

    /**
     * @var DynamicComponentsConfigFactory
     */
    private $dynamicComponentsConfigFactory;

    /**
     * @var ComponentConfigFactory
     */
    private $componentConfigFactory;

    /**
     * @var Status
     */
    private $moduleStatus;

    /**
     * ConfigFactory constructor.
     *
     * @param CollectionFactory $componentCollectionFactory
     * @param DynamicComponentsConfigFactory $dynamicComponentsConfigFactory
     * @param ComponentConfigFactory $componentConfigFactory
     * @param Status $moduleStatus
     */
    public function __construct(
        CollectionFactory $componentCollectionFactory,
        DynamicComponentsConfigFactory $dynamicComponentsConfigFactory,
        ComponentConfigFactory $componentConfigFactory,
        Status $moduleStatus
    ) {
        $this->componentCollectionFactory = $componentCollectionFactory;
        $this->dynamicComponentsConfigFactory = $dynamicComponentsConfigFactory;
        $this->componentConfigFactory = $componentConfigFactory;
        $this->moduleStatus = $moduleStatus;
    }

    /**
     * create
     *
     * @return DynamicComponentsConfig
     */
    public function create()
    {
        /** @var DynamicComponentsConfig $dynamicComponentConfig */
        $dynamicComponentConfig = $this->dynamicComponentsConfigFactory->create();

        /** @var Component $component */
        foreach ($this->getComponentCollection() as $component) {
            if ($component->getStatus() === Component::STATUS_ENABLED) {
                /** @var ComponentConfig $componentConfig */
                $componentConfig = $this->componentConfigFactory->create();
                $componentConfig->setName($component->getName());
                $componentConfig->setPath($component->getPath());
                $componentConfig->setPsr4Prefix($component->getPsr4Prefix());
                $componentConfig->setType(Component\TypeMapper::map($component->getType()));

                $dynamicComponentConfig->addComponent($componentConfig);
            } else if ($component->getType() === Component::TYPE_MODULE) {
                $this->moduleStatus->setIsEnabled(
                    false,
                    [$component->getName()]
                );
            }
        }

        return $dynamicComponentConfig;
    }

    /**
     * getComponentCollection
     *
     * @return Collection
     */
    protected function getComponentCollection()
    {
        return $this->componentCollectionFactory->create();
    }
}
