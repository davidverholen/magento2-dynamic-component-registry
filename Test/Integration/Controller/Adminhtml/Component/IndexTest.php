<?php
/**
 * IndexTest.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Index;
use Magento\Backend\Model\View\Result\Page;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class IndexTest
 *
 * @category           magento2
 * @package            DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component
 * @author             David Verholen <david@verholen.com>
 * @license            http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link               http://github.com/davidverholen
 *
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
}
