<?php
/**
 * ComponentTypeValidator.php
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
 * Class ComponentTypeValidator
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ComponentTypeValidator extends AbstractValidator
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
                $this->validateTheModuleConfigIsPresent($component->getPath());
                break;
            case Component::TYPE_LANGUAGE:
                /** @TODO add validation for language pack */
            case Component::TYPE_THEME:
                /** @TODO add validation for theme */
            case Component::TYPE_LIBRARY:
                /** @TODO add validation for library */
        }
    }

    protected function validateTheModuleConfigIsPresent($path)
    {
        if (false === file_exists($this->getModuleConfigPath($path))) {
            $this->addError(__(sprintf(
                'Module Config not found: \'%s\'',
                $this->getModuleConfigPath($path)
            )));
        }
    }
}
