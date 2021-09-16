<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Academy\DeclarativeSchemaModule\Api\Data;

interface IpAddressSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get IpAddress list.
     * @return \Academy\DeclarativeSchemaModule\Api\Data\IpAddressInterface[]
     */
    public function getItems();

    /**
     * Set current_ip_address list.
     * @param \Academy\DeclarativeSchemaModule\Api\Data\IpAddressInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

