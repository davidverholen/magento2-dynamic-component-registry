<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\Component;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProviderInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component\CollectionFactory;

class DataProvider extends AbstractDataProvider implements DataProviderInterface
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     *
     * @param string            $name
     * @param string            $primaryFieldName
     * @param string            $requestFieldName
     * @param CollectionFactory $componentCollectionFactory
     * @param array             $meta
     * @param array             $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $componentCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );

        $this->collection = $componentCollectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        /** @var Component $component */
        foreach ($this->collection->getItems() as $component) {
            $result['general'] = $component->getData();
            $this->loadedData[$component->getId()] = $result;
        }

        return $this->loadedData;
    }
}
