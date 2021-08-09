<?php
namespace Academy\SuperDuperModule\Block;

class Hello extends \Magento\Framework\View\Element\Template
{
    public function getHelloWorldTxt(string $message)
    {
        return 'Hello world!'.$message;
    }
}
