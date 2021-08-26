<?php

namespace Academy\HyperCypherModule\Model\Attribute\Source;

class Brand extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Nike'), 'value' => 'nike'],
                ['label' => __('Adidas'), 'value' => 'adidas'],
                ['label' => __('Puma'), 'value' => 'puma'],
                ['label' => __('Reebok'), 'value' => 'reebok']
            ];
        }
        return $this->_options;
    }
}
