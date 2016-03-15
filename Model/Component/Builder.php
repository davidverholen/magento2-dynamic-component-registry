<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\Component;

use DavidVerholen\DynamicComponentRegistry\Api\ComponentRepositoryInterface;
use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterfaceFactory;
use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Psr\Log\LoggerInterface;

class Builder
{
    const CURRENT_COMPONENT_ID = 'current_component_id';
    const CURRENT_COMPONENT = 'current_component';

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var ComponentRepositoryInterface
     */
    protected $componentRepository;

    /**
     * @var ComponentInterfaceFactory
     */
    protected $componentFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Builder constructor.
     *
     * @param Registry $registry
     * @param ComponentRepositoryInterface $componentRepository
     * @param ComponentInterfaceFactory $componentFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Registry $registry,
        ComponentRepositoryInterface $componentRepository,
        ComponentInterfaceFactory $componentFactory,
        LoggerInterface $logger
    ) {
        $this->registry = $registry;
        $this->componentRepository = $componentRepository;
        $this->componentFactory = $componentFactory;
        $this->logger = $logger;
    }

    /**
     * @param $componentId
     *
     * @return ComponentInterface|Component
     */
    public function build($componentId)
    {
        $this->registry->register(static::CURRENT_COMPONENT_ID, $componentId);

        try {
            $component = $this->componentRepository->get($componentId);
            $this->registry->register(static::CURRENT_COMPONENT, $component);

            return $component;
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }

        return $this->componentFactory->create();
    }
}
