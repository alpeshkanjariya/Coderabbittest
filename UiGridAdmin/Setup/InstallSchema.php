<?php

namespace ScripCo\UiGridAdmin\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var string
     */
    private static $table = 'sales_order_grid';

    /**
     * @var string
     */
    private static $connectionName = 'sales';

    /**
     * @inheritdoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var AdapterInterface $connection */
        $connection = $setup->startSetup()->getConnection(self::$connectionName);
        $connection->addColumn(
            $setup->getTable(static::$table),
            'ma_po_number',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Purchase Order Number',
            ]
        );

        $connection->addColumn(
            $setup->getTable(static::$table),
            'billing_customer_edp',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Billing Customer EDP',
            ]
        );

        $connection->addColumn(
            $setup->getTable(static::$table),
            'billing_customer_number',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Billing Customer Number',
            ]
        );

        $connection->addColumn(
            $setup->getTable(static::$table),
            'shipping_customer_edp',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Shipping Customer EDP',
            ]
        );

        $connection->addColumn(
            $setup->getTable(static::$table),
            'shipping_customer_number',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' => 'Shipping Customer Number',
            ]
        );

        $connection->addColumn(
            $setup->getTable(static::$table),
            'tax_amount',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'length' => '12,4',
                'comment' => 'Tax Amount',
            ]
        );

        $connection->dropIndex(
            $setup->getTable(static::$table),
            $setup->getIdxName(
                $setup->getTable(static::$table),
                [
                    'increment_id',
                    'billing_name',
                    'shipping_name',
                    'shipping_address',
                    'billing_address',
                    'customer_name',
                    'customer_email'
                ],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            )
        );

        $connection->addIndex(
            $setup->getTable(static::$table),
            $setup->getIdxName(
                $setup->getTable(static::$table),
                ['increment_id', 'customer_email', 'ecometry_order_number', 'billing_customer_number'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['increment_id', 'customer_email', 'ecometry_order_number', 'billing_customer_number'],
            AdapterInterface::INDEX_TYPE_FULLTEXT
        );
    }
}
