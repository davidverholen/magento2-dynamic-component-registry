<?php
use DavidVerholen\DynamicComponentRegistry\Model\Serializable\ConfigFactory;
use DavidVerholen\DynamicComponentRegistry\Serializable\ComponentConfig;
use DavidVerholen\DynamicComponentRegistry\Serializable\DynamicComponentsConfig;
use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\SerializerBuilder;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'DavidVerholen_DynamicComponentRegistry',
    __DIR__
);

if (defined('BP')) {
    $configFilePath = implode(DIRECTORY_SEPARATOR, [
        BP,
        DirectoryList::VAR_DIR,
        ConfigFactory::CONFIG_DIR,
        ConfigFactory::CONFIG_FILE_NAME
    ]);

    if (file_exists($configFilePath)) {
        AnnotationRegistry::registerLoader('class_exists');
        /** @var DynamicComponentsConfig $dynamicComponentsConfig */
        $dynamicComponentsConfig = SerializerBuilder::create()->build()->deserialize(
            file_get_contents($configFilePath),
            DynamicComponentsConfig::class,
            ConfigFactory::CONFIG_FORMAT
        );

        /** @var \Composer\Autoload\ClassLoader $composerAutoloader */
        $composerAutoloader = null;
        $registeredAutoloaders = spl_autoload_functions();
        array_walk_recursive($registeredAutoloaders, function ($value) use (&$composerAutoloader) {
            if ($value instanceof \Composer\Autoload\ClassLoader) {
                $composerAutoloader = $value;
            }
        });

        /** @var ComponentConfig $componentConfig */
        foreach ($dynamicComponentsConfig->getComponents() as $componentConfig) {
            if (null !== $composerAutoloader) {
                $composerAutoloader->addPsr4(
                    $componentConfig->getPsr4Prefix(),
                    $componentConfig->getPath()
                );
            }

            ComponentRegistrar::register(
                $componentConfig->getType(),
                $componentConfig->getName(),
                $componentConfig->getPath()
            );
        }
    }
}

