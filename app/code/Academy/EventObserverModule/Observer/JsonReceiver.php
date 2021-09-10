<?php

namespace Academy\EventObserverModule\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class JsonReceiver implements ObserverInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData();

        $this->logger->info($item[0]);

    }
}
