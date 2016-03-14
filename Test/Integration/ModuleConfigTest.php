<?php
/**
 * ModuleConfigTest.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\ObjectManager;

/**
 * Class ModuleConfigTest
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Test\Integration
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
    private $moduleName = 'DavidVerholen_DynamicComponentRegistry';

    public function testTheModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->moduleName, $registrar->getPaths(ComponentRegistrar::MODULE));
    }

    public function testTheModuleIsConfiguredAndEnabled()
    {
        /** @var ModuleList $moduleList */
        $moduleList = $this->getObjectManager()->create(ModuleList::class);

        $this->assertTrue($moduleList->has($this->moduleName), 'The Module is not enabled');
    }

    /**
     * getObjectManager
     *
     * @return ObjectManager
     */
    private function getObjectManager()
    {
        $objectManager = ObjectManager::getInstance();
        return $objectManager;
    }
}
