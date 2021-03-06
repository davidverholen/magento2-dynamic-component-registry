<?php
/**
 * Psr4PrefixValidator.php
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
use Magento\Framework\Model\AbstractModel;

/**
 * Class Psr4PrefixValidator
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class Psr4PrefixValidator extends AbstractValidator
{
    /**
     * validate
     *
     * @param ComponentInterface|AbstractModel $component
     *
     * @return void
     */
    protected function execute(ComponentInterface $component)
    {
        $this->validateHasTrailingSlash($component->getPsr4Prefix());
        $this->validateHasNoLeadingSlash($component->getPsr4Prefix());
        $this->validateHasNoDoubleBackslash($component->getPsr4Prefix());
    }

    protected function validateHasTrailingSlash($psr4Prefix)
    {
        if (!empty($psr4Prefix) && '\\' !== substr($psr4Prefix, -1)) {
            $this->addError(__('PSR-4 Namespace Prefix must have a trailing \'\\\' (example: \'Vendor\\Namespace\\\')'));
        }
    }

    protected function validateHasNoLeadingSlash($psr4Prefix)
    {
        if (!empty($psr4Prefix) && '\\' === substr($psr4Prefix, 0, 1)) {
            $this->addError(__('PSR-4 Namespace Prefix must not have a leading \'\\\' (example: \'Vendor\\Namespace\\\')'));
        }
    }

    protected function validateHasNoDoubleBackslash($psr4Prefix)
    {
        if (false !== strpos($psr4Prefix, '\\\\')) {
            $this->addError(__('PSR-4 Namespace Prefix must not have escaped \'\\\' (example: \'Vendor\\Namespace\\\')'));
        }
    }
}
