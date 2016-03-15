<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Model;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component as ComponentResource;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\TestFramework\ObjectManager;

class ComponentTest extends \PHPUnit_Framework_TestCase
{
    protected $interfaceName = ComponentInterface::class;

    public function testAnInstanceCanBeCreated()
    {
        $this->assertInstanceOf(ComponentInterface::class, $this-> createComponent());
    }

    public function testTheResourceModelCanBeObtained()
    {
        $this->assertInstanceOf(AbstractDb::class, $this->createComponent()->getResource());
    }

    public function testTheCollectionCanBeObtained()
    {
        $this->assertInstanceOf(AbstractCollection::class, $this->createComponent()->getCollection());
    }

    public function testTheGettersAndSettersAreWorking()
    {
        $component = $this->createComponent();
        $this->assertEquals('name', $component->setName('name')->getName());
        $this->assertEquals('type', $component->setType('type')->getType());
        $this->assertEquals('path', $component->setPath('path')->getPath());
        $this->assertEquals('status', $component->setStatus('status')->getStatus());
    }

    /**
     * @return ComponentInterface|AbstractModel
     */
    protected function createComponent()
    {
        return ObjectManager::getInstance()->create(ComponentInterface::class);
    }
}
