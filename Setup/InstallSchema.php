<?php

namespace DavidVerholen\DynamicComponentRegistry\Setup;

use DavidVerholen\DynamicComponentRegistry\Api\Data\ComponentInterface;
use DavidVerholen\DynamicComponentRegistry\Model\ResourceModel\Component as ComponentResource;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable(ComponentResource::MAIN_TABLE)
        )->addColumn(
            ComponentInterface::COMPONENT_ID,
            Table::TYPE_SMALLINT,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Component ID'
        )->addColumn(
            ComponentInterface::NAME,
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Component Name'
        )->addColumn(
            ComponentInterface::PATH,
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Component Path'
        )->addColumn(
            ComponentInterface::PSR4_PREFIX,
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Component PSR-4 Prefix'
        )->addColumn(
            ComponentInterface::TYPE,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Component Type'
        )->addColumn(
            ComponentInterface::STATUS,
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Component Status'
        )->setComment(
            'Dynamic Component Table'
        );

        $setup->getConnection()->createTable($table);
    }
}
