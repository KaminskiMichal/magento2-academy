<?php

namespace Academy\DeclarativeSchemaModule\Cron;

use Academy\DeclarativeSchemaModule\Api\Data\IpAddressInterfaceFactory;
use Academy\DeclarativeSchemaModule\Api\IpAddressRepositoryInterface;
use Psr\Log\LoggerInterface;

class StoreIpChecker
{
    protected $logger;
    private IpAddressRepositoryInterface $ipAddressRepository;
    private IpAddressInterfaceFactory $ipAddressFactory;

    public function __construct(
        LoggerInterface $logger,
        IpAddressRepositoryInterface $ipAddressRepository,
        IpAddressInterfaceFactory $ipAddressFactory
    ) {
        $this->logger = $logger;
        $this->ipAddressRepository = $ipAddressRepository;
        $this->ipAddressFactory = $ipAddressFactory;
    }

    public function execute()
    {
        $ipAddress = $this->ipAddressFactory->create();
        $ipAddress->setCurrentIpAddress(file_get_contents('https://ipinfo.io/ip'));

        $this->ipAddressRepository->save($ipAddress);

        $this->logger->info('Ip checker cron job');
    }
}
