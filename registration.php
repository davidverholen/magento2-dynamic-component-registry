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
        /** @var DynamicComponentsConfig $config */
        $config = SerializerBuilder::create()->build()->deserialize(
            file_get_contents($configFilePath),
            DynamicComponentsConfig::class,
            ConfigFactory::CONFIG_FORMAT
        );

        $autoloaders = spl_autoload_functions();
        /** @var \Composer\Autoload\ClassLoader $autoloader */
        $autoloader = null;
        if (isset($autoloaders[0])
            && isset($autoloaders[0][0])
            && $autoloaders[0][0] instanceof \Composer\Autoload\ClassLoader
        ) {
            $autoloader = $autoloaders[0][0];
        }

        /** @var ComponentConfig $componentConfig */
        foreach ($config->getComponents() as $componentConfig) {
            if (null !== $autoloader) {
                $autoloader->addPsr4(
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

