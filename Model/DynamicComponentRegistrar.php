<?php
/**
 * DynamicComponentRegistrar.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Model;

use Composer\Autoload\ClassLoader;
use DavidVerholen\DynamicComponentRegistry\Model\Serializable\ConfigFactory;
use DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfig;
use DavidVerholen\DynamicComponentRegistry\Serializable\DynamicComponentsConfig;
use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\SerializerBuilder;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Component\ComponentRegistrar;

/**
 * Class DynamicComponentRegistrar
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Model
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class DynamicComponentRegistrar
{
    /**
     * @var DynamicComponentRegistrar
     */
    private static $instance;

    /**
     * @var bool
     */
    private static $componentsRegistered = false;

    /**
     * @var string
     */
    private $configFilePath;

    /**
     * @var ClassLoader
     */
    private $composerAutoloader;

    private function __construct()
    {
        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * getInstance
     *
     * @return DynamicComponentRegistrar
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * registerDynamicComponents
     *
     * @return void
     */
    public function registerDynamicComponents()
    {
        if (false === $this->canExecute()) {
            return;
        }

        /** @var ComponentConfig $componentConfig */
        foreach ($this->getComponents() as $componentConfig) {
            if (null !== $this->getComposerAutoloader()
                && !empty($componentConfig->getPsr4Prefix())
            ) {
                $this->addPsr4($componentConfig);
            }

            $this->registerDynamicComponent($componentConfig);
        }

        self::$componentsRegistered = true;
    }

    /**
     * getComponents
     *
     * @return \DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfig[]
     */
    private function getComponents()
    {
        return $this->getDynamicComponentsConfig()->getComponents();
    }

    /**
     * registerDynamicComponent
     *
     * @param ComponentConfig $componentConfig
     *
     * @return void
     */
    private function registerDynamicComponent(ComponentConfig $componentConfig)
    {
        ComponentRegistrar::register(
            $componentConfig->getType(),
            $componentConfig->getName(),
            $componentConfig->getPath()
        );
    }

    /**
     * addPsr4
     *
     * @param ComponentConfig $componentConfig
     *
     * @return void
     */
    private function addPsr4(ComponentConfig $componentConfig)
    {
        $this->getComposerAutoloader()->addPsr4(
            $componentConfig->getPsr4Prefix(),
            $componentConfig->getPath()
        );
    }

    /**
     * getDynamicComponentsConfig
     *
     * @return DynamicComponentsConfig
     */
    private function getDynamicComponentsConfig()
    {
        try {
            /** @var DynamicComponentsConfig $dynamicComponentsConfig */
            return SerializerBuilder::create()->build()->deserialize(
                file_get_contents($this->getConfigFilePath()),
                DynamicComponentsConfig::class,
                ConfigFactory::CONFIG_FORMAT
            );
        } catch (\Exception $e) {
            printf('<h3>Dynamic Component Registry - Broken Configuration File</h3>');
            printf('<p>error while reading Dynamic Components Config: <b>%s</b></p>',
                $e->getMessage());
            printf('<p>1. Delete <b>\'%s\'</b> to get the Page running again<br/>',
                $this->getConfigFilePath());
            printf('2. run <b>bin/magento setup:upgrade</b><br/>');
            printf('3. Afterwards save any Dynamic Component in Backend to recreate the Configuration File</p>');
            exit;
        }
    }

    /**
     * getConfigFilePath
     *
     * @return string
     */
    private function getConfigFilePath()
    {
        if (!defined('BP')) {
            return (string)null;
        }
        if (null === $this->configFilePath) {
            $this->configFilePath = implode(DIRECTORY_SEPARATOR, [
                BP,
                DirectoryList::VAR_DIR,
                ConfigFactory::CONFIG_DIR,
                ConfigFactory::CONFIG_FILE_NAME
            ]);
        }

        return $this->configFilePath;
    }

    /**
     * configExists
     *
     * @return bool
     */
    private function configExists()
    {
        return file_exists($this->getConfigFilePath());
    }

    private function getComposerAutoloader()
    {
        if (null === $this->composerAutoloader) {
            /** @var \Composer\Autoload\ClassLoader $composerAutoloader */
            $composerAutoloader = null;
            $registeredAutoloaders = spl_autoload_functions();

            array_walk_recursive(
                $registeredAutoloaders,
                function ($value) use (&$composerAutoloader) {
                    if ($value instanceof ClassLoader) {
                        $composerAutoloader = $value;
                    }
                }
            );

            $this->composerAutoloader = $composerAutoloader;
        }

        return $this->composerAutoloader;
    }

    /**
     * canExecute
     *
     * @return bool
     */
    private function canExecute()
    {
        return true === $this->configExists()
        && false === self::$componentsRegistered
        && defined('BP');
    }
}
