<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ZeroGravity\Directory\Model;

/**
 * @api
 * @since 100.0.2
 */
class CityFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }

    /**
     * Create new city model
     *
     * @param array $arguments
     * @return \ZeroGravity\Directory\Model\City
     */
    public function create(array $arguments = [])
    {
        return $this->_objectManager->create(\ZeroGravity\Directory\Model\City::class, $arguments);
    }
}
