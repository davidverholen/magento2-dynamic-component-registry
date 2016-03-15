<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Model\ResourceModel;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Model\Component as ComponentModel;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component;
use Magento\TestFramework\ObjectManager;

class ComponentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Component
     */
    protected $subject;

    /**
     * @var ComponentModel
     */
    protected $model;

    protected function setUp()
    {
        parent::setUp();

        /** @var ObjectManager $objectManager */
        $objectManager = ObjectManager::getInstance();
        $this->model = $objectManager->create(ComponentInterface::class);
        $this->subject = $this->model->getResource();
    }

    public function testTheMainTableIsSet()
    {
        $this->assertEquals(Component::MAIN_TABLE, $this->subject->getMainTable());
    }

    public function testTheIdFieldNameIsSet()
    {
        $this->assertEquals(ComponentInterface::COMPONENT_ID, $this->subject->getIdFieldName());
    }
}
