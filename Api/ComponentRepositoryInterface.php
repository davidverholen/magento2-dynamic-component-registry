<?php

namespace DavidVerholen\DynamicComponentRegistry\Api;

use Magento\Framework\Api\Search\SearchCriteriaInterface;

interface ComponentRepositoryInterface
{
    /**
     * @param Data\ComponentInterface $component
     * @return Data\ComponentInterface
     */
    public function save(Data\ComponentInterface $component);

    /**
     * @param int $componentId
     * @return Data\ComponentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($componentId);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Data\ComponentSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param Data\ComponentInterface $component
     * @return bool true on success
     */
    public function delete(Data\ComponentInterface $component);

    /**
     * @param int $componentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($componentId);
}
