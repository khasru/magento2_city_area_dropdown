<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ZeroGravity\Directory\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();


        /**
         * Create table 'directory_country_city'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('directory_country_city')
        )->addColumn(
            'city_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'City Id'
        )->addColumn(
            'country_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            4,
            ['nullable' => false, 'default' => '0'],
            'Country Id in ISO-2'
        )->addColumn(
            'code',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            32,
            ['nullable' => true, 'default' => null],
            'City code'
        )->addColumn(
            'name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            [],
            'City Name'
        )->addIndex(
            $installer->getIdxName('directory_country_city', ['country_id']),
            ['country_id']
        )->setComment(
            'Directory Country City'
        );
        $installer->getConnection()->createTable($table);

        $tableName="directory_country_region";

        //ALTER TABLE `directory_country_region` ADD `city` VARCHAR(256) NULL DEFAULT NULL AFTER `default_name`;
        $installer->getConnection()->query('ALTER TABLE `' . $tableName . '` ADD `city` VARCHAR(256) NULL DEFAULT NULL AFTER `default_name`');

        $installer->endSetup();
    }
}
