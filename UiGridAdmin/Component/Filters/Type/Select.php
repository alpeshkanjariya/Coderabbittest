<?php

namespace ScripCo\UiGridAdmin\Component\Filters\Type;

class Select extends \Magento\Ui\Component\Filters\Type\Select
{
    /**
     * Apply filter
     *
     * @return void
     */
    protected function applyFilter()
    {
        if ($this->getName() == 'store_id' && !isset($this->filterData['store_id']) && $this->getContext() && is_a($this->getContext()->getDataProvider(), \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider::class)) {
            try {
                $filter = $this->filterBuilder->setConditionType('eq')
                    ->setField($this->getName())
                    ->setValue(\Magento\Store\Model\Store::DEFAULT_STORE_ID)
                    ->create();
                $this->getContext()->getDataProvider()->addFilter($filter);
            } catch (\Exception $e) {
                parent::applyFilter();
            }
        } else {
            parent::applyFilter();
        }
    }
}
