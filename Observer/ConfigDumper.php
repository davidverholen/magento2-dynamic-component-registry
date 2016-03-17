<?php
/**
 * ConfigDumper.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\DynamicComponentRegistry\Observer;

use DavidVerholen\DynamicComponentRegistry\Model\Serializable\ConfigFactory;
use DavidVerholen\DynamicComponentRegistry\Model\SerializerFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\Observer as ObserverEventObject;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem\Directory\WriteFactory as DirectoryWriteFactory;
use Magento\Framework\Filesystem\Driver\File;

/**
 * Class ConfigDumper
 *
 * @category magento2
 * @package  DavidVerholen\DynamicComponentRegistry\Observer
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ConfigDumper implements ObserverInterface
{
    /**
     * @var SerializerFactory
     */
    private $serializerFactory;

    /**
     * @var ConfigFactory
     */
    private $configFactory;

    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @var DirectoryWriteFactory
     */
    private $directoryWriteFactory;

    /**
     * @var File
     */
    private $fileDriver;

    /**
     * ConfigDumper constructor.
     *
     * @param SerializerFactory     $serializerFactory
     * @param ConfigFactory         $configFactory
     * @param DirectoryList         $directoryList
     * @param DirectoryWriteFactory $directoryWriteFactory
     * @param File                  $fileDriver
     */
    public function __construct(
        SerializerFactory $serializerFactory,
        ConfigFactory $configFactory,
        DirectoryList $directoryList,
        DirectoryWriteFactory $directoryWriteFactory,
        File $fileDriver
    ) {
        $this->serializerFactory = $serializerFactory;
        $this->configFactory = $configFactory;
        $this->directoryList = $directoryList;
        $this->directoryWriteFactory = $directoryWriteFactory;
        $this->fileDriver = $fileDriver;
    }


    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(ObserverEventObject $observer)
    {
        $this->dumpConfigToFile();
    }

    /**
     * dumpConfigToFile
     *
     * @return int
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function dumpConfigToFile()
    {
        if (false === $this->createConfigDir()) {
            return false;
        }

        if (false === $this->fileDriver->isExists($this->getConfigFilePath())) {
            $this->fileDriver->touch($this->getConfigFilePath());
        }

        return $this->fileDriver->filePutContents(
            $this->getConfigFilePath(),
            $this->getConfigJson()
        ) > 0;
    }

    /**
     * createConfigDir
     *
     * @return bool
     */
    protected function createConfigDir()
    {
        return $this->directoryWriteFactory
            ->create($this->directoryList->getPath(DirectoryList::VAR_DIR))
            ->create(ConfigFactory::CONFIG_DIR);
    }

    /**
     * getConfigFilePath
     *
     * @return string
     */
    protected function getConfigFilePath()
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->getConfigDirPath(),
            ConfigFactory::CONFIG_FILE_NAME
        ]);
    }

    /**
     * getConfigDirPath
     *
     * @return string
     */
    protected function getConfigDirPath()
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->directoryList->getPath('var'),
            ConfigFactory::CONFIG_DIR
        ]);
    }

    /**
     * getConfigJson
     *
     * @return string
     */
    protected function getConfigJson()
    {
        return $this->getSerializer()->serialize(
            $this->configFactory->create(),
            ConfigFactory::CONFIG_FORMAT
        );
    }

    /**
     * getSerializer
     *
     * @return \JMS\Serializer\Serializer
     */
    protected function getSerializer()
    {
        return $this->serializerFactory->get();
    }
}
