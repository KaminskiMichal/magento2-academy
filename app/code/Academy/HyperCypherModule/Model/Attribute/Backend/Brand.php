<?php

namespace Academy\HyperCypherModule\Model\Attribute\Backend;

class Brand extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * Validate
     * @param \Magento\Catalog\Model\Product $object
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    protected array $brands = ['Nike', 'Adidas', 'Puma', 'Reebok'];

    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (($object->getAttributeSetId() == 10) && ($value == 'adidas')) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Bottom can not be adidas.')
            );
        }
        return true;
    }

    public function beforeSave($object)
    {
        //$brands = ['Nike', 'Adidas', 'Puma', 'Reebok'];
        $value = $object->getData($this->getAttribute()->getAttributeCode());

        if (in_array($value, $this->brands))
            return true;

        echo 'Error - brand is not one of the following: [Nike, Adidas, Puma, Reebok]';
        return false;
    }
}
