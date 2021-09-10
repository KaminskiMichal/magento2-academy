<?php

namespace Academy\SuperDuperModule\Plugin;


use Academy\SuperDuperModule\Console\WriteHelloWorld;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductInterface;

use function GuzzleHttp\Psr7\str;

class ProductChangerApi
{


    public function beforeSave(
        ProductRepositoryInterface $subject,
        ProductInterface $product,
        $saveOptions = false
    ) {
        echo "Before\n";
        $dupa = 3;
        $product->setWeight(2);
    }

//    public function aroundTest(WriteHelloWorld $subject, callable $proceed, string $test)
//    {
//        $test = 'text changed again';
//
//        echo "Around before\n";
//
//        $result = $proceed($test);
//
//        echo "Around after\n";
//
//        return $result;
//    }
//
//    public function afterTest(WriteHelloWorld $subject, string $result, string $test)
//    {
//        echo "After\n";
//
//        return $result;
//    }
}
