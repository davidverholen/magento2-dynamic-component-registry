<?php
/**
 * ModulePathValidator.php
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

/**
 * Class ModulePathValidator
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ComponentPathValidator extends AbstractValidator
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
        $this->validateThePathExists($component->getPath());
    }

    protected function validateThePathExists($path)
    {
        if (false === file_exists($this->getNormalizedPath($path))) {
            $this->addError(__(sprintf(
                'the path does not exist: \'%s\'. The path must be relative to the Magento root dir',
                $this->getNormalizedPath($path)
            )));
        }
    }
}
