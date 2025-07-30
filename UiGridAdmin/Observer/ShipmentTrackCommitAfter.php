<?php

namespace ScripCo\UiGridAdmin\Observer;

use Magento\Framework\Event\ObserverInterface;

use Psr\Log\LoggerInterface;

class ShipmentTrackCommitAfter implements ObserverInterface
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
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order\Shipment\Track $track */
        $track = $observer->getEvent()->getTrack();

        if ($track instanceof \Magento\Sales\Model\Order\Shipment\Track) {
            try {
                $resource = $track->getResource();
                $track->getResource()->getTable('sales_shipment_grid');
                $trackingSelect = $resource->getConnection()
                                ->select()
                                ->from($resource->getTable('sales_shipment_track'), ['GROUP_CONCAT(`track_number`) AS tracking'])
                                ->where('parent_id =?', $track->getParentId());
                $resource->getConnection()->update($resource->getTable('sales_shipment_grid'), ['tracking' => new \Zend_Db_Expr("(" . $trackingSelect . ")")], ['entity_id = ?'=> $track->getParentId()]);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
