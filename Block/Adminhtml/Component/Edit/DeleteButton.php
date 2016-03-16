<?php

namespace DavidVerholen\DynamicComponentRegistry\Block\Adminhtml\Component\Edit;

use DavidVerholen\DynamicComponentRegistry\Model\Component\Builder;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * DeleteButton constructor.
     *
     * @param Registry     $registry
     * @param UrlInterface $urlBuilder
     */
    public function __construct(Registry $registry, UrlInterface $urlBuilder)
    {
        $this->registry = $registry;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'id' => 'delete',
            'label' => __('Delete'),
            'class' => 'delete',
            'url' => $this->urlBuilder->getUrl('*/*/delete', ['_query' => [
                'id' => $this->registry->registry(Builder::CURRENT_COMPONENT_ID)
            ]]),
            'sort_order' => 10
        ];
    }
}
