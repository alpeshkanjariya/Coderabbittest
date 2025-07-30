<?php
namespace ScripCo\UiGridAdmin\Model\Product\Entity\Attribute\Source;

use Magento\Catalog\Model\Product\Attribute\Repository as AttributeRepository;
use Magento\Framework\Escaper;
use \Amasty\ShopbyBrand\Helper\Data;

class Brand extends AbstractSource
{
    protected Data $_shopByBrandHelper;

    public function __construct(
        AttributeRepository $attributeRepository,
        Data $shopByBrandHelper,
        Escaper $escaper = null
    ) {
        parent::__construct($attributeRepository, $escaper);
        $this->_shopByBrandHelper = $shopByBrandHelper;
    }

    public function getAttributeCode()
    {
        return $this->_shopByBrandHelper->getBrandAttributeCode();
    }
}
