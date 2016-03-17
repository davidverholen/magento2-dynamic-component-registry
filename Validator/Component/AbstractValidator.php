<?php
/**
 * AbstractValidator.php
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
 * Class AbstractValidator
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Validator\Component
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $errors = [];

    /**
     * validate
     *
     * @param ComponentInterface|AbstractModel $component
     *
     * @return boolean
     */
    public function validate(ComponentInterface $component)
    {
        $this->resetErrors();
        $this->execute($component);
        return false === $this->hasErrors();
    }

    /**
     * execute
     *
     * @param ComponentInterface $component
     *
     * @return void
     */
    abstract protected function execute(ComponentInterface $component);

    /**
     * addError
     *
     * @param $errorMsg
     *
     * @return void
     */
    protected function addError($errorMsg)
    {
        $this->errors[] = $errorMsg;
    }

    /**
     * getErrors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * hasErrors
     *
     * @return bool
     */
    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    /**
     * resetErrors
     *
     * @return void
     */
    private function resetErrors()
    {
        $this->errors = [];
    }

    /**
     * getNormalizedPath
     *
     * @param $path
     *
     * @return string
     */
    protected function getNormalizedPath($path)
    {
        return $this->normalizePath(implode(DIRECTORY_SEPARATOR, [BP, $path]));
    }

    /**
     * getModuleConfigPath
     *
     * @param $path
     *
     * @return string
     */
    protected function getModuleConfigPath($path)
    {
        return $this->normalizePath(implode(DIRECTORY_SEPARATOR, [
            BP,
            $path,
            'etc',
            'module.xml'
        ]));
    }

    /**
     * normalize_path
     *
     * @param $path
     *
     * @return string
     * @throws \Exception
     */
    protected function normalizePath($path) {
        $parts = explode('/', $path);
        $result = [];

        foreach ($parts as $part) {
            if ('..' === $part) {
                if (!count($result) || ($result[count($result) - 1] == '..')) {
                    $result[] = $part;
                } else {
                    array_pop($result);
                }
            } elseif ('.' !== $part) {
                $result[] = $part;
            }
        }
        return implode('/', $result);
    }
}
