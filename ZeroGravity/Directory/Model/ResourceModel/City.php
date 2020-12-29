<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace ZeroGravity\Directory\Model\ResourceModel;

/**
 * City Resource Model
 *
 * @api
 * @since 100.0.2
 */
class City extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Table with localized city names
     *
     * @var string
     */
    protected $_regionNameTable;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
        $this->_localeResolver = $localeResolver;
    }

    /**
     * Define main and locale city name tables
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('directory_country_city', 'city_id');

    }
}
