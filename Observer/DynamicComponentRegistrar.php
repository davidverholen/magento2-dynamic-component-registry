<?php

namespace DavidVerholen\DynamicComponentRegistry\Observer;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component\Collection;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component\CollectionFactory;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class DynamicComponentRegistrar implements ObserverInterface
{
    private static $shouldExecute = true;

    /**
     * @var ComponentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * DynamicComponentRegistrar constructor.
     *
     * @param ComponentRegistrar $componentRegistrar
     * @param CollectionFactory  $collectionFactory
     */
    public function __construct(
        ComponentRegistrar $componentRegistrar,
        CollectionFactory $collectionFactory
    ) {
        $this->componentRegistrar = $componentRegistrar;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (false === static::$shouldExecute) {
            return;
        }

        static::$shouldExecute = false;

        /** @var Component $component */
        foreach ($this->getComponentCollection() as $component) {
            $this->componentRegistrar->register(
                Component\TypeMapper::map($component->getType()),
                $component->getName(),
                $component->getPath()
            );
        }
    }

    /**
     * @return Collection
     */
    protected function getComponentCollection()
    {
        return $this->collectionFactory->create();
    }
}
