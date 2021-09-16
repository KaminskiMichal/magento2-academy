<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Academy\DeclarativeSchemaModule\Api\Data;

interface IpAddressInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CURRENT_IP_ADDRESS = 'current_ip_address';
    const IPADDRESS_ID = 'ipaddress_id';

    /**
     * Get ipaddress_id
     * @return string|null
     */
    public function getIpaddressId();

    /**
     * Set ipaddress_id
     * @param string $ipaddressId
     * @return \Academy\DeclarativeSchemaModule\Api\Data\IpAddressInterface
     */
    public function setIpaddressId($ipaddressId);

    /**
     * Get current_ip_address
     * @return string|null
     */
    public function getCurrentIpAddress();

    /**
     * Set current_ip_address
     * @param string $currentIpAddress
     * @return \Academy\DeclarativeSchemaModule\Api\Data\IpAddressInterface
     */
    public function setCurrentIpAddress($currentIpAddress);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Academy\DeclarativeSchemaModule\Api\Data\IpAddressExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Academy\DeclarativeSchemaModule\Api\Data\IpAddressExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Academy\DeclarativeSchemaModule\Api\Data\IpAddressExtensionInterface $extensionAttributes
    );
}

