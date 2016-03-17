<?php
/**
 * ValidatorInterface.php
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
use Magento\Framework\Model\AbstractModel;

interface ValidatorInterface
{
    /**
     * validate
     *
     * @param ComponentInterface|AbstractModel $component
     *
     * @return boolean
     */
    public function validate(ComponentInterface $component);

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors();

    /**
     * hasErrors
     *
     * @return boolean
     */
    public function hasErrors();
}
