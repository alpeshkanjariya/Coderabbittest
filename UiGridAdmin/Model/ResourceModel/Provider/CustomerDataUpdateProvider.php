<?php
namespace ScripCo\UiGridAdmin\Model\ResourceModel\Provider;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Sales\Model\ResourceModel\Provider\NotSyncedDataProviderInterface;

class CustomerDataUpdateProvider implements NotSyncedDataProviderInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var AdapterInterface
     */
    private $connection;

    /**
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->connection = $resourceConnection->getConnection();
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @inheritdoc
     */
    public function getIds($mainTableName, $gridTableName)
    {
        if (strpos($gridTableName, 'sales_order_grid') !== false) {
            $gridTableName = $this->resourceConnection->getTableName($gridTableName);
            $addressTableName = $this->resourceConnection->getTableName('magento_customercustomattributes_sales_flat_order_address');
            $orderAddressTableName = $this->resourceConnection->getTableName('sales_order_address');
            $select = $this->connection->select()
                ->from($orderAddressTableName, [$orderAddressTableName . '.parent_id'])
                ->joinInner(
                    [$addressTableName => $addressTableName],
                    sprintf(
                        '%s.entity_id = %s.entity_id',
                        $addressTableName,
                        $orderAddressTableName
                    ),
                    []
                )->joinLeft(
                    [$gridTableName => $gridTableName],
                    sprintf(
                        '%s.%s = %s.%s',
                        $orderAddressTableName,
                        'parent_id',
                        $gridTableName,
                        'entity_id'
                    ),
                    []
                )->where(
                    '((coalesce(' . $gridTableName . '.billing_customer_edp,1) != coalesce(' . $addressTableName . '.customer_edp,1) 
                    OR coalesce(' . $gridTableName . '.billing_customer_number,1) != coalesce(' . $addressTableName . '.customer_number,1)) 
                    AND ' . $orderAddressTableName . '.address_type = "billing") 
                    OR ((coalesce(' . $gridTableName . '.shipping_customer_edp,1) != coalesce(' . $addressTableName . '.customer_edp,1) 
                    OR coalesce(' . $gridTableName . '.shipping_customer_number,1) != coalesce(' . $addressTableName . '.customer_number,1)) 
                    AND ' . $orderAddressTableName . '.address_type = "shipping")'
                );

            return $this->connection->fetchAll($select, [], \Zend_Db::FETCH_COLUMN);
        } elseif (strpos($gridTableName, 'sales_shipment_grid') !== false || strpos($gridTableName, 'sales_invoice_grid') !== false || strpos($gridTableName, 'sales_creditmemo_grid') !== false) {
            $gridTableName = $this->resourceConnection->getTableName($gridTableName);
            if (strpos($gridTableName, 'sales_shipment_grid') !== false) {
                $masterTable = $this->resourceConnection->getTableName('sales_shipment');
            } elseif (strpos($gridTableName, 'sales_invoice_grid') !== false) {
                $masterTable = $this->resourceConnection->getTableName('sales_invoice');
            } elseif (strpos($gridTableName, 'sales_creditmemo_grid') !== false) {
                $masterTable = $this->resourceConnection->getTableName('sales_creditmemo');
            }
            $addressTableName = $this->resourceConnection->getTableName('magento_customercustomattributes_sales_flat_order_address');
            $orderAddressTableName = $this->resourceConnection->getTableName('sales_order_address');

            $select = $this->connection->select()
                            ->from($masterTable, ['order_ids' => "DISTINCT({$masterTable}.order_id)"])
                            ->joinInner(
                                [$orderAddressTableName => $orderAddressTableName],
                                "{$masterTable}.order_id = {$orderAddressTableName}.parent_id",
                                []
                            )->joinInner(
                                [$addressTableName => $addressTableName],
                                "{$addressTableName}.entity_id = {$orderAddressTableName}.entity_id",
                                []
                            )->joinLeft(
                                [$gridTableName => $gridTableName],
                                "{$orderAddressTableName}.parent_id = {$gridTableName}.order_id",
                                []
                            )->where(
                                '((coalesce(' . $gridTableName . '.billing_customer_edp,1) != coalesce(' . $addressTableName . '.customer_edp,1) 
				OR coalesce(' . $gridTableName . '.billing_customer_number,1) != coalesce(' . $addressTableName . '.customer_number,1)) 
				AND ' . $orderAddressTableName . '.address_type = "billing") 
				OR ((coalesce(' . $gridTableName . '.shipping_customer_edp,1) != coalesce(' . $addressTableName . '.customer_edp,1) 
				OR coalesce(' . $gridTableName . '.shipping_customer_number,1) != coalesce(' . $addressTableName . '.customer_number,1)) 
				AND ' . $orderAddressTableName . '.address_type = "shipping")'
                            );

            return $this->connection->fetchAll($select, [], \Zend_Db::FETCH_COLUMN);
        } else {
            return [];
        }
    }
}
