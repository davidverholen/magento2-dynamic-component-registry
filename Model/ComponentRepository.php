<?php

namespace DavidVerholen\DynamicComponentRegistry\Model;

use DavidVerholen\DynamicComponentRegistry\Api\ComponentRepositoryInterface;
use DavidVerholen\DynamicComponentRegistry\Api\Data;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component as ComponentResource;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Reflection\DataObjectProcessor;

class ComponentRepository implements ComponentRepositoryInterface
{
    /**
     * @var ComponentResource
     */
    protected $resource;

    /**
     * @var Data\ComponentInterface[]
     */
    protected $instances = [];

    /**
     * @var ComponentFactory
     */
    protected $componentFactory;

    /**
     * @var Data\ComponentSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var ComponentResource\CollectionFactory
     */
    protected $componentCollectionFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * ComponentRepository constructor.
     *
     * @param ComponentResource                          $resource
     * @param ComponentFactory                           $componentFactory
     * @param Data\ComponentSearchResultInterfaceFactory $searchResultsFactory
     * @param ComponentResource\CollectionFactory        $componentCollectionFactory
     * @param DataObjectHelper                           $dataObjectHelper
     * @param DataObjectProcessor                        $dataObjectProcessor
     */
    public function __construct(
        ComponentResource $resource,
        ComponentFactory $componentFactory,
        Data\ComponentSearchResultInterfaceFactory $searchResultsFactory,
        ComponentResource\CollectionFactory $componentCollectionFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->componentFactory = $componentFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->componentCollectionFactory = $componentCollectionFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * @param Data\ComponentInterface $component
     *
     * @return Data\ComponentInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ComponentInterface $component)
    {
        if (false === ($component instanceof AbstractModel)) {
            throw new CouldNotSaveException(__('Invalid Model'));
        }

        /** @var AbstractModel $component */
        try {
            $this->resource->save($component);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $component;
    }

    /**
     * @param int $componentId
     *
     * @return Data\ComponentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($componentId)
    {
        if (false === array_key_exists($componentId, $this->instances)) {
            /** @var Component $component */
            $component = $this->componentFactory->create();
            $this->resource->load($component, $componentId);
            if (!$component->getId()) {
                throw new NoSuchEntityException(__('Component with id "%1" does not exist.', $componentId));
            }

            $this->instances[$componentId] = $component;
        }

        return $this->instances[$componentId];
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     *
     * @return Data\ComponentSearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var Data\ComponentSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var ComponentResource\Collection $collection */
        $collection = $this->componentCollectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();

        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $components = [];
        /** @var Component $componentModel */
        foreach ($collection as $componentModel) {
            $componentData = $this->componentFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $componentData,
                $componentModel->getData(),
                Data\ComponentInterface::class
            );

            $components[] = $this->dataObjectProcessor->buildOutputDataArray(
                $componentData,
                Data\ComponentInterface::class
            );
        }

        $searchResults->setItems($components);

        return $searchResults;
    }

    /**
     * @param Data\ComponentInterface $component
     *
     * @return bool true on success
     * @throws CouldNotDeleteException
     */
    public function delete(Data\ComponentInterface $component)
    {
        if (false === ($component instanceof AbstractModel)) {
            throw new CouldNotDeleteException(__('Invalid Model'));
        }

        /** @var AbstractModel $component */
        try {
            $this->resource->delete($component);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param int $componentId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($componentId)
    {
        return $this->delete($this->get($componentId));
    }
}
