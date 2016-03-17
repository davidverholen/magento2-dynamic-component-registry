<?php
/**
 * ModuleNameValidator.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Validator\Component;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Model\Component;

/**
 * Class ModuleNameValidator
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ComponentNameValidator extends AbstractValidator
{

    /**
     * execute
     *
     * @param ComponentInterface $component
     *
     * @return void
     */
    protected function execute(ComponentInterface $component)
    {
        switch ($component->getType()) {
            case Component::TYPE_MODULE:
                $this->validateModuleNameMatchesTheConfig($component);
                break;
            case Component::TYPE_LANGUAGE:
                /** @TODO add validation for language pack */
            case Component::TYPE_THEME:
                /** @TODO add validation for theme */
            case Component::TYPE_LIBRARY:
                /** @TODO add validation for library */
        }
    }

    protected function validateModuleNameMatchesTheConfig(
        ComponentInterface $component
    ) {
        $moduleConfigFile = $this->getModuleConfigPath($component->getPath());
        if (file_exists($moduleConfigFile)) {
            $moduleConfig = simplexml_load_file($moduleConfigFile);
            if ($moduleConfig->{'module'}['name'] !== $component->getName()) {
                $this->addError(__(sprintf(
                    'The Module Name does not Match the Configuration: \'%s\'',
                    $moduleConfig->{'module'}['name']
                )));
            }
        }
    }
}
