<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\NewAction;
use Magento\Backend\Model\View\Result\Forward;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * @magentoAppArea     adminhtml
 * @magentoDbIsolation enabled
 */
class NewActionTest extends AbstractBackendController
{
    protected $uri = 'backend/dynamic_component_registry/component/new';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = NewAction::class;

    public function testTheActionReturnsAResultForward()
    {
        /** @var NewAction $newAction */
        $newAction = $this->_objectManager->create($this->action);
        $this->assertInstanceOf(Forward::class, $newAction->execute());
    }
}
