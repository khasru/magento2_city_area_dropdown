<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ZeroGravity\Directory\Model\ResourceModel\City;

use Magento\Directory\Model\AllowedCountries;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\ScopeInterface;

/**
 * Cityes collection
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 *
 * @api
 * @since 100.0.2
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Locale city name table name
     *
     * @var string
     */
    protected $_regionNameTable;

    /**
     * Country table name
     *
     * @var string
     */
    protected $_countryTable;

    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @var AllowedCountries
     */
    private $allowedCountriesReader;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactory $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param mixed $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactory $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->_localeResolver = $localeResolver;
        $this->_resource = $resource;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Define main, country, locale city name tables
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\ZeroGravity\Directory\Model\City::class, \ZeroGravity\Directory\Model\ResourceModel\City::class);

        $this->_countryTable = $this->getTable('directory_country');
     //   $this->_regionNameTable = $this->getTable('directory_country_region_name');

        $this->addOrder('name', \Magento\Framework\Data\Collection::SORT_ORDER_ASC);

    }


    /**
     * Return Allowed Countries reader
     *
     * @return \Magento\Directory\Model\AllowedCountries
     * @deprecated 100.1.4
     */
    private function getAllowedCountriesReader()
    {
        if (!$this->allowedCountriesReader) {
            $this->allowedCountriesReader = ObjectManager::getInstance()->get(AllowedCountries::class);
        }

        return $this->allowedCountriesReader;
    }

    /**
     * Set allowed countries filter based on the given store.
     * This is a convenience method for collection filtering based on store configuration settings.
     *
     * @param null|int|string|\Magento\Store\Model\Store $store
     * @return \ZeroGravity\Directory\Model\ResourceModel\City\Collection
     * @since 100.1.4
     */
    public function addAllowedCountriesFilter($store = null)
    {
        $allowedCountries = $this->getAllowedCountriesReader()
            ->getAllowedCountries(ScopeInterface::SCOPE_STORE, $store);

        if (!empty($allowedCountries)) {
            $this->addFieldToFilter('main_table.country_id', ['in' => $allowedCountries]);
        }

        return $this;
    }

    /**
     * Filter by country_id
     *
     * @param string|array $countryId
     * @return $this
     */
    public function addCountryFilter($countryId)
    {
        if (!empty($countryId)) {
            if (is_array($countryId)) {
                $this->addFieldToFilter('main_table.country_id', ['in' => $countryId]);
            } else {
                $this->addFieldToFilter('main_table.country_id', $countryId);
            }
        }
        return $this;
    }

    /**
     * Filter by country code (ISO 3)
     *
     * @param string $countryCode
     * @return $this
     */
    public function addCountryCodeFilter($countryCode)
    {
        $this->getSelect()->joinLeft(
            ['country' => $this->_countryTable],
            'main_table.country_id = country.country_id'
        )->where(
            'country.iso3_code = ?',
            $countryCode
        );

        return $this;
    }

    /**
     * Filter by City code
     *
     * @param string|array $cityCode
     * @return $this
     */
    public function addCityCodeFilter($cityCode)
    {
        if (!empty($cityCode)) {
            if (is_array($cityCode)) {
                $this->addFieldToFilter('main_table.code', ['in' => $cityCode]);
            } else {
                $this->addFieldToFilter('main_table.code', $cityCode);
            }
        }
        return $this;
    }

    /**
     * Filter by city name
     *
     * @param string|array $cityName
     * @return $this
     */
    public function addCityNameFilter($cityName)
    {
        if (!empty($cityName)) {
            if (is_array($cityName)) {
                $this->addFieldToFilter('main_table.name', ['in' => $cityName]);
            } else {
                $this->addFieldToFilter('main_table.name', $cityName);
            }
        }
        return $this;
    }

    /**
     * Filter city by its code or name
     *
     * @param string|array $city
     * @return $this
     */
    public function addCityCodeOrNameFilter($city)
    {
        if (!empty($city)) {
            $condition = is_array($city) ? ['in' => $city] : $city;
            $this->addFieldToFilter(
                ['main_table.code', 'main_table.name'],
                [$condition, $condition]
            );
        }
        return $this;
    }

    /**
     * Convert collection items to select options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this as $item) {
            if ($item->getCode()) {
                $option['value'] = $item->getCode();
                $option['label'] = $item->getName();
                $options[] = $option;
            }
        }

        if (count($options) > 0) {
            array_unshift(
                $options,
                ['value' => '', 'label' => __('Please select a city.')]
            );
        }
        return $options;
    }
}
