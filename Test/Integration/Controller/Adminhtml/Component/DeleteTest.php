<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Delete;
use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\Framework\Message\MessageInterface;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

class DeleteTest extends AbstractBackendController
{
    const FIXTURE_NAME = 'VendorName_ModuleName';
    const FIXTURE_PATH = '/path/to/module';

    protected $uri = 'backend/dynamic_component_registry/component/delete';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = Delete::class;

    /**
     * @magentoDataFixture componentFixture
     */
    public function testDeleteAction()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()
            ->create(Component::class)
            ->load(static::FIXTURE_NAME, ComponentInterface::NAME);

        $this->dispatch(implode('/', [$this->uri, 'id', $component->getId()]));
        $this->assertRedirect($this->stringStartsWith(
            'http://localhost/index.php/backend/dynamic_component_registry/component/index/'
        ));

        $this->assertSessionMessages(
            $this->contains('You deleted the Component.'),
            MessageInterface::TYPE_SUCCESS
        );

        /** @var Component $deletedComponent */
        $deletedComponent = ObjectManager::getInstance()->create(Component::class);
        $deletedComponent->load($component->getId());

        $this->assertNull($deletedComponent->getId());
    }

    public static function componentFixture()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()->create(Component::class);
        $component
            ->setName(static::FIXTURE_NAME)
            ->setStatus(Component::STATUS_ENABLED)
            ->setType(Component::TYPE_MODULE)
            ->setPath(static::FIXTURE_PATH);

        $component->save();
    }
}
