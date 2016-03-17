<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Save;
use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\Message\MessageInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class EditTest
 * @package            DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component
 *
 * @magentoAppArea     adminhtml
 */
class SaveTest extends AbstractBackendController
{
    const FIXTURE_NAME = 'VendorName_ModuleName';
    const FIXTURE_PATH = '/path/to/module';

    protected $uri = 'backend/dynamic_component_registry/component/save';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = Save::class;

    /**
     * @magentoDataFixture componentFixture
     */
    public function testSaveAction()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()
            ->create(Component::class)
            ->load(static::FIXTURE_NAME, ComponentInterface::NAME);

        $newPath = '/new/path/to/module';
        $component->setPath($newPath);

        $this->getRequest()->setPostValue(['general' => $component->getData()]);

        $this->dispatch(implode('/', [$this->uri, 'id', $component->getId()]));
        $this->assertRedirect($this->stringStartsWith(
            'http://localhost/index.php/backend/dynamic_component_registry/component/index/'
        ));
        $this->assertSessionMessages(
            $this->contains('You saved the Component.'),
            MessageInterface::TYPE_SUCCESS
        );

        /** @var Component $newComponent */
        $newComponent = Bootstrap::getObjectManager()->create(Component::class);
        $newComponent->load(static::FIXTURE_NAME, ComponentInterface::NAME);

        $this->assertEquals($newPath, $newComponent->getPath());
    }

    public static function componentFixture()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()->create(Component::class);
        $component
            ->setName(static::FIXTURE_NAME)
            ->setStatus(Component::STATUS_DISABLED)
            ->setType(Component::TYPE_MODULE)
            ->setPath(static::FIXTURE_PATH);

        $component->save();
    }
}
