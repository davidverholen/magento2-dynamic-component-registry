<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Validate;
use Magento\Framework\Controller\Result\Json;
use Magento\TestFramework\TestCase\AbstractBackendController;

class ValidateTest extends AbstractBackendController
{
    protected $uri = 'backend/dynamic_component_registry/component/new';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = Validate::class;

    public function testTheActionReturnsAResultJson()
    {
        /** @var Validate $action */
        $action = $this->_objectManager->create($this->action);
        $this->assertInstanceOf(Json::class, $action->execute());
    }
}
