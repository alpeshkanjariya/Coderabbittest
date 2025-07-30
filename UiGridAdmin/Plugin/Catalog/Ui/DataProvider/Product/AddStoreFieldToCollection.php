<?php
namespace ScripCo\UiGridAdmin\Plugin\Catalog\Ui\DataProvider\Product;

use Magento\Catalog\Ui\DataProvider\Product\AddStoreFieldToCollection as SubjectAddStoreFieldToCollection;
use Magento\Framework\Data\Collection;

class AddStoreFieldToCollection
{
    /**
     * {@inheritdoc}
     */
    public function afterAddFilter(SubjectAddStoreFieldToCollection $subject, $result, Collection $collection, $field, $condition = null)
    {
        if (isset($condition['eq']) && $condition['eq'] == \Magento\Store\Model\Store::DEFAULT_STORE_ID) {
            $collection->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
        }
    }
}
