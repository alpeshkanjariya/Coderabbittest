<?php

namespace ScripCo\UiGridAdmin\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $installer->getConnection();
            // sales_shipment_grid columns
            $connection->addColumn(
                $installer->getTable('sales_shipment_grid'),
                'ecometry_order_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Order Ecometry Number'
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'billing_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'billing_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer Number',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'shipping_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'shipping_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer Number',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'tax_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => '12,4',
                    'comment' => 'Tax Amount',
                ]
            );

            // sales_invoice_grid columns

            $connection->addColumn(
                $installer->getTable('sales_invoice_grid'),
                'ecometry_order_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Order Ecometry Number'
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'billing_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'billing_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer Number',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'shipping_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'shipping_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer Number',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'tax_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => '12,4',
                    'comment' => 'Tax Amount',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'cc_type',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '32',
                    'comment' => 'Cc Type',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_invoice_grid'),
                'order_status',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '32',
                    'comment' => 'Order Status',
                ]
            );

            // sales_creditmemo_grid columns
            $connection->addColumn(
                $installer->getTable('sales_creditmemo_grid'),
                'ecometry_order_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'nullable' => true,
                    'comment' => 'Order Ecometry Number'
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'billing_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'billing_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Billing Customer Number',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'shipping_customer_edp',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer EDP',
                ]
            );

            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'shipping_customer_number',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Shipping Customer Number',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'invoice_increment_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '50',
                    'comment' => 'Invoice Increment Id',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'invoice_created_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'comment' => 'Invoice Created Date',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'tax_amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => '12,4',
                    'comment' => 'Tax Amount',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'cc_type',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '32',
                    'comment' => 'Cc Type',
                ]
            );
            $connection->addColumn(
                $setup->getTable('sales_creditmemo_grid'),
                'invoice_grand_total',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'length' => '12,4',
                    'comment' => 'Invoice Grand Total',
                ]
            );

            // Set FullText index

            $connection->dropIndex(
                $setup->getTable('sales_shipment_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_shipment_grid'),
                    [
                        'increment_id',
                        'order_increment_id',
                        'shipping_name',
                        'customer_name',
                        'customer_email',
                        'billing_address',
                        'shipping_address'
                    ],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                )
            );

            $connection->addIndex(
                $setup->getTable('sales_shipment_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_shipment_grid'),
                    ['increment_id', 'order_increment_id', 'ecometry_order_number', 'shipping_customer_number'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['increment_id', 'order_increment_id', 'ecometry_order_number', 'shipping_customer_number'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            $connection->dropIndex(
                $setup->getTable('sales_invoice_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_invoice_grid'),
                    [
                        'increment_id',
                        'order_increment_id',
                        'billing_name',
                        'billing_address',
                        'shipping_address',
                        'customer_name',
                        'customer_email'
                    ],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                )
            );

            $connection->addIndex(
                $setup->getTable('sales_invoice_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_invoice_grid'),
                    ['increment_id', 'order_increment_id', 'ecometry_order_number', 'billing_customer_number'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['increment_id', 'order_increment_id', 'ecometry_order_number', 'billing_customer_number'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );

            $connection->dropIndex(
                $setup->getTable('sales_creditmemo_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_creditmemo_grid'),
                    [
                        'increment_id',
                        'order_increment_id',
                        'billing_name',
                        'billing_address',
                        'shipping_address',
                        'customer_name',
                        'customer_email'
                    ],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                )
            );

            $connection->addIndex(
                $setup->getTable('sales_creditmemo_grid'),
                $setup->getIdxName(
                    $setup->getTable('sales_creditmemo_grid'),
                    ['increment_id', 'invoice_increment_id', 'order_increment_id', 'ecometry_order_number', 'billing_customer_number'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['increment_id', 'invoice_increment_id', 'order_increment_id', 'ecometry_order_number', 'billing_customer_number'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $connection = $installer->getConnection();
            $connection->addColumn(
                $setup->getTable('sales_order_grid'),
                'cc_type',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => '32',
                    'comment' => 'Cc Type',
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $connection = $installer->getConnection();
            $connection->dropColumn($setup->getTable('sales_invoice_grid'), 'shipping_customer_number');
            $connection->dropColumn($setup->getTable('sales_invoice_grid'), 'shipping_customer_edp');
            $connection->dropColumn($setup->getTable('sales_creditmemo_grid'), 'shipping_customer_number');
            $connection->dropColumn($setup->getTable('sales_creditmemo_grid'), 'shipping_customer_edp');
            $connection->dropColumn($setup->getTable('sales_shipment_grid'), 'billing_customer_number');
            $connection->dropColumn($setup->getTable('sales_shipment_grid'), 'billing_customer_edp');
        }
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $connection = $installer->getConnection();
            $connection->addColumn(
                $setup->getTable('sales_shipment_grid'),
                'tracking',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' => 'Tracking Numbers',
                ]
            );
        }
        $installer->endSetup();
    }
}
