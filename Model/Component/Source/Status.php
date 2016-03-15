<?php

namespace DavidVerholen\DynamicComponentRegistry\Model\Component\Source;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @var array
     */
    protected static $options = [];

    /**
     * @var Component
     */
    protected $componentModel;

    /**
     * Status constructor.
     *
     * @param Component $componentModel
     */
    public function __construct(Component $componentModel)
    {
        $this->componentModel = $componentModel;
    }


    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        if (0 === count(static::$options)) {
            foreach ($this->componentModel->getAvailableStatuses() as $value => $label) {
                static::$options[] = [
                    'value' => $value,
                    'label' => $label
                ];
            }
        }

        return static::$options;
    }
}
