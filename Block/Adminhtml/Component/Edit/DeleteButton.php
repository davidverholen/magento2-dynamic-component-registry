<?php

namespace DavidVerholen\DynamicComponentRegistry\Block\Adminhtml\Component\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'id' => 'delete',
            'label' => __('Delete'),
            'class' => 'delete',
            'sort_order' => 10
        ];
    }
}
