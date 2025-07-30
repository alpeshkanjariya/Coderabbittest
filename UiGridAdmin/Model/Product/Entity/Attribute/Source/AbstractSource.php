<?php
namespace ScripCo\UiGridAdmin\Model\Product\Entity\Attribute\Source;

use Magento\Catalog\Model\Product\Attribute\Repository as AttributeRepository;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;

class AbstractSource extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    private $attributeRepository;

    private $escaper;

    protected $_attributeValues = [];

    public function __construct(
        AttributeRepository $attributeRepository,
        Escaper $escaper = null
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->escaper = $escaper ?: ObjectManager::getInstance()->get(Escaper::class);
    }

    public function toOptionArray()
    {
        if (!isset($this->_attributeValues[$this->getAttributeCode()])) {
            $options = [];
            try {
                $attribute = $this->attributeRepository->get($this->getAttributeCode());
                if ($attribute) {
                    if ($attribute->usesSource()) {
                        $options = $attribute->getSource()->getAllOptions();
                    }
                }
            } catch (\Exception $e) {
                $options = [];
            }
            $this->_attributeValues[$this->getAttributeCode()] = $options;
        }
        return $this->_attributeValues[$this->getAttributeCode()];
    }

    public function getAllOptions()
    {
        return $this->toOptionArray();
    }

    protected function convertOptionsValueToString(array $options)
    {
        array_walk($options, function (&$value) {
            if (isset($value['value']) && is_scalar($value['value'])) {
                $value['value'] = (string)$value['value'];
            }
        });
        return $options;
    }
}
