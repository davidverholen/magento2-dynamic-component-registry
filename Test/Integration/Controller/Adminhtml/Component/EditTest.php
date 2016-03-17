<?php

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration\Controller\Adminhtml\Component;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Controller\Adminhtml\Component\Edit;
use DavidVerholen\DynamicComponentRegistry\Model\Component;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\AbstractBackendController;

class EditTest extends AbstractBackendController
{
    const FIXTURE_NAME = 'VendorName_ModuleName';
    const FIXTURE_PATH = '/path/to/module';

    protected $uri = 'backend/dynamic_component_registry/component/edit';
    protected $resource = 'DavidVerholen_DynamicComponentRegistry::dynamic_component_registry_component';
    protected $action = Edit::class;

    /**
     * @magentoDataFixture componentFixture
     */
    public function testTheComponentIsLoadedIntoTheForm()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()->create(Component::class);
        $component->load(static::FIXTURE_NAME, ComponentInterface::NAME);

        $this->dispatch(implode('/', [$this->uri, 'id', $component->getId()]));

        $content = $this->getResponse()->getBody();
        $this->assertContains(static::FIXTURE_NAME, $content);
    }

    /**
     * @magentoDataFixture componentFixture
     */
    public function testAllNeededButtonsArePresent()
    {
        /** @var Component $component */
        $component = ObjectManager::getInstance()->create(Component::class);
        $component->load(static::FIXTURE_NAME, ComponentInterface::NAME);

        $this->dispatch(implode('/', [$this->uri, 'id', $component->getId()]));
        $content = $this->getResponse()->getBody();
        $this->assertContains('<span>Save</span>', $content);
        $this->assertContains('<span>Delete</span>', $content);
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
