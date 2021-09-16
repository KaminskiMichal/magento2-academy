<?php

namespace Academy\EmailModule\Plugin;

use Academy\EmailModule\Helper\CatalogChangeMailSender;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class NewProductMailSenderApi
{

    private ScopeConfigInterface $scopeConfig;
    private CatalogChangeMailSender $catalogChangeMailSender;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CatalogChangeMailSender $catalogChangeMailSender
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->catalogChangeMailSender = $catalogChangeMailSender;
    }

    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions = false
    ) {
        if ($this->scopeConfig->isSetFlag(
            'product/email/emailOnCreation',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            $this->catalogChangeMailSender->sendEmail(
                $product->getSku(),
                $product->getName(),
                $product->getPrice()
            );
        }
    }

}
