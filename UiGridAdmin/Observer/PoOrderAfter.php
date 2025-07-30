<?php

namespace ScripCo\UiGridAdmin\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;
use ScripCo\Epurch\Helper\Data;

class PoOrderAfter implements ObserverInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ShipmentTrackCommitAfter constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(
        private readonly ResourceConnection $resource,
        LoggerInterface $logger,
        private readonly  OrderRepositoryInterface $orderRepository,
        private readonly  Data $dataHelper
    ) {
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order\Shipment\Track $track */
        $po = $observer->getEvent()->getPoRequest();
        $epurchRequest = $this->dataHelper->getPurchaseOrderById($po->getEntityId());
        if ($orderId = $epurchRequest->getOrderId()) {
            try {
                $poNumber = $po->getIncrementId();
                $orderObj = $this->orderRepository->get($orderId);
                $connection  = $this->resource->getConnection();
                $salesOrderTable   = $connection->getTableName('sales_order');
                $salesOrderGridTable   = $connection->getTableName('sales_order_grid');
                $connection->update($salesOrderTable, ['ma_po_number' => $poNumber], ['entity_id = ?'=> $orderId]);
                $connection->update($salesOrderGridTable, ['ma_po_number' => $poNumber], ['increment_id = ?'=> $orderObj->getIncrementId()]);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
