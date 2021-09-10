<?php

namespace Academy\EmailModule\Plugin;

use Academy\EmailModule\Helper\CatalogChangeMailSender;
use Magento\Catalog\Controller\Adminhtml\Product\Save;
use Magento\Framework\App\Config\ScopeConfigInterface;

class NewProductMailSenderAdmin
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

    public function beforeExecute(Save $subject)
    {
        $product = $subject->getRequest()->getPostValue()['product'];

        if ($this->scopeConfig->isSetFlag(
            'product/email/emailOnCreation',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            $this->catalogChangeMailSender->sendEmail(
                $product['sku'],
                $product['name'],
                $product['price']
            );
        }
    }

}
