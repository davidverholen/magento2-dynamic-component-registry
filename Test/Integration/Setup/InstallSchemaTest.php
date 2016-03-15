<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Setup;

use DavidVerholen\DynamicComponentRegistry\Model\Component;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component as ComponentResource;
use Magento\Framework\App\ResourceConnection;
use Magento\TestFramework\ObjectManager;

class InstallSchemaTest extends \PHPUnit_Framework_TestCase
{
    protected $moduleName = 'DavidVerholen_DynamicComponentRegistry';
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var Component
     */
    protected $componentModel;

    /**
     * @var ComponentResource
     */
    protected $componentResource;

    protected function setUp()
    {
        parent::setUp();
        $this->resourceConnection = ObjectManager::getInstance()->get(ResourceConnection::class);
        $this->componentModel = ObjectManager::getInstance()->create(Component::class);
        $this->componentResource = $this->componentModel->getResource();
    }

    public function testTheModuleIsInstalled()
    {
        $select = $this->resourceConnection->getConnection()
            ->select()
            ->from('setup_module', 'module')
            ->where('module LIKE :module_name');

        $this->assertEquals(
            $this->moduleName,
            $this->resourceConnection->getConnection()->fetchOne($select, [
                'module_name' => $this->moduleName
            ])
        );
    }

    public function testTheTableExists()
    {
        $this->assertContains(ComponentResource::MAIN_TABLE, $this->resourceConnection->getConnection()->getTables());
    }
}
