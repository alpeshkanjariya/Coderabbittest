<?php
namespace ScripCo\UiGridAdmin\Model\ResourceModel\Provider;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Sales\Model\ResourceModel\Provider\NotSyncedDataProviderInterface;

class OrderDataUpdateProvider implements NotSyncedDataProviderInterface
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
            $mainTableName = $this->resourceConnection->getTableName($mainTableName);
            $gridTableName = $this->resourceConnection->getTableName($gridTableName);
            $paymentTableName = $this->resourceConnection->getTableName('sales_order_payment');

            $select = $this->connection->select()
                ->from($mainTableName, [$mainTableName . '.entity_id'])
                ->joinLeft(
                    [$gridTableName => $gridTableName],
                    sprintf(
                        '%s.%s = %s.%s',
                        $mainTableName,
                        'entity_id',
                        $gridTableName,
                        'entity_id'
                    ),
                    []
                )
                ->joinLeft(
                    [$paymentTableName => $paymentTableName],
                    sprintf(
                        '%s.%s = %s.%s',
                        $mainTableName,
                        'entity_id',
                        $paymentTableName,
                        'parent_id'
                    ),
                    []
                )
                ->where($gridTableName . '.tax_amount IS NULL')
                ->orWhere("coalesce({$paymentTableName}.cc_type, 1) != coalesce({$gridTableName}.cc_type,1 )");

            return $this->connection->fetchAll($select, [], \Zend_Db::FETCH_COLUMN);
        } elseif (strpos($gridTableName, 'sales_shipment_grid') !== false || strpos($gridTableName, 'sales_invoice_grid') !== false || strpos($gridTableName, 'sales_creditmemo_grid') !== false) {
            $mainTableName = $this->resourceConnection->getTableName($mainTableName);
            $gridTableName = $this->resourceConnection->getTableName($gridTableName);

            $select = $this->connection->select()
                ->from($mainTableName, [$mainTableName . '.entity_id'])
                ->joinLeft(
                    [$gridTableName => $gridTableName],
                    sprintf(
                        '%s.%s = %s.%s',
                        $mainTableName,
                        'entity_id',
                        $gridTableName,
                        'order_id'
                    ),
                    []
                )
                ->where($gridTableName . '.tax_amount IS NULL');

            return $this->connection->fetchAll($select, [], \Zend_Db::FETCH_COLUMN);
        } else {
            return [];
        }
    }
}
