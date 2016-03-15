<?php

namespace DavidVerholen\DynamicComponentRegistry\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ComponentSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ComponentInterface[]
     */
    public function getItems();

    /**
     * @param ComponentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
