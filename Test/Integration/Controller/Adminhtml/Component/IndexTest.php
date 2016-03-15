<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Index;
use Magento\Backend\Model\View\Result\Page;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * @magentoAppArea     adminhtml
 * @magentoDbIsolation enabled
 */
class IndexTest extends AbstractBackendController
{
    protected $uri = 'backend/dynamic_component_registry/component/index';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = Index::class;

    public function testTheAddNewButtonIsPresent()
    {
        $this->dispatch($this->uri);
        $this->assertContains('Add New Component', $this->getResponse()->getBody());
    }

    public function testTheActionReturnsAResultPage()
    {
        /** @var Index $indexAction */
        $indexAction = $this->_objectManager->create($this->action);
        $this->assertInstanceOf(Page::class, $indexAction->execute());
    }

    public function testAllRequiredGridColumnsAreShown()
    {
        $this->dispatch($this->uri);
        $this->assertContains(__('Name')->__toString(), $this->getResponse()->getBody());
        $this->assertContains(__('Type')->__toString(), $this->getResponse()->getBody());
        $this->assertContains(__('Path')->__toString(), $this->getResponse()->getBody());
        $this->assertContains(__('Status')->__toString(), $this->getResponse()->getBody());
    }
}
