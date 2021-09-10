<?php

namespace Academy\IndexerModule\Model\Indexer;


use Psr\Log\LoggerInterface;

class NamesAlphabetical implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /*
         * Used by mview, allows process indexer in the "Update on schedule" mode
    */

    public function execute($ids)
    {
        //Used by mview, allows you to process multiple placed orders in the "Update on schedule" mode
        $this->logger->info("indexer works - execute");
    }

    /*
     * Will take all of the data and reindex
     * Will run when reindex via command line
     */
    public function executeFull()
    {
        $this->logger->info("indexer works - executeFull");
        //Should take into account all placed orders in the system
    }

    /*
     * Works with a set of entity changed (may be massaction)
     */
    public function executeList(array $ids)
    {
        $this->logger->info("indexer works - execute list ");
        //Works with a set of placed orders (mass actions and so on)
    }

    /*
     * Works in runtime for a single entity using plugins
     */
    public function executeRow($id)
    {
        $this->logger->info("indexer works - execute single");
        //Works in runtime for a single order using plugins
    }
}
