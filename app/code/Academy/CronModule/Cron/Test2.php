<?php

namespace Academy\CronModule\Cron;

use Psr\Log\LoggerInterface;

class Test2
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->info('Cron Works');
    }
}
