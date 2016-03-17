<?php
/**
 * ValidatorPool.php
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
 * Class ValidatorPool
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ValidatorPool
{
    /**
     * @var ValidatorInterface[]
     */
    protected $validators;

    /**
     * ValidatorPool constructor.
     *
     * @param ValidatorInterface[] $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    /**
     * validateAll
     *
     * @param ComponentInterface $component
     *
     * @return array
     */
    public function validateAll(ComponentInterface $component)
    {
        $errors = [];
        /** @var ValidatorInterface $validator */
        foreach ($this->validators as $validator) {
            if (false === $validator->validate($component)) {
                $errors = array_merge($errors, $validator->getErrors());
            }
        }

        return $errors;
    }
}
