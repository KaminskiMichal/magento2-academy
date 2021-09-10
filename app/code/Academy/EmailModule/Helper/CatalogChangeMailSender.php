<?php

namespace Academy\EmailModule\Helper;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Catalog\Api\Data\ProductInterface;

class CatalogChangeMailSender
{


    private TransportBuilder $transportBuilder;
    private ScopeConfigInterface $scopeConfig;
    private ProductRepositoryInterface $productRepository;

    public function __construct(ScopeConfigInterface $scopeConfig, TransportBuilder $transportBuilder, ProductRepositoryInterface $productRepository)
    {
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
    }

    public function sendEmail($sku, $name, $price)
    {

        try {
            $existingProduct = $this->productRepository->get($sku);

            $oldName = $existingProduct->getName($sku);
            $oldPrice = $existingProduct->getPrice($sku);

            $emailTemplateIdentifier = 'updated_product_info';
            $templateVars = [
                "sku" => $sku,
                "product_name" => $name,
                'old_product_name' => $oldName,
                "product_price" => $price,
                'old_product_price' => $oldPrice,
                'subject' => 'Updated product info',
            ];

        } catch (NoSuchEntityException $e) {
            $emailTemplateIdentifier = 'new_product_info';
            $templateVars = [
                "sku" => $sku,
                "product_name" => $name,
                "product_price" => $price,
                'subject' => 'New product info'
            ];
        }

        $templateOptions = array(
            'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
            'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID
        );

        $from = array(
            'email' => "michal.kaminski@solteq.com",
            'name' => 'Michał Kamiński'
        );

        $addressString = $this->scopeConfig->getValue(
            'product/email/emailList',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $address = explode(',', $addressString);

        $transport = $this->transportBuilder
            ->setTemplateIdentifier($emailTemplateIdentifier)
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($address)
            ->getTransport();

        $transport->sendMessage();
    }


}
