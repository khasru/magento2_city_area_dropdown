<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ZeroGravity\Directory\Model;

use Magento\Directory\Api\Data\CountryInformationExtensionFactory;
use Magento\Directory\Api\Data\RegionInformationExtensionFactory;

/**
 * Currency information acquirer class
 */
class CountryInformationAcquirer extends \Magento\Directory\Model\CountryInformationAcquirer
{

    protected $cityInformationFactory;

    /**
     * @param \Magento\Directory\Model\Data\CountryInformationFactory $countryInformationFactory
     * @param \Magento\Directory\Model\Data\RegionInformationFactory $regionInformationFactory
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Directory\Model\Data\CountryInformationFactory $countryInformationFactory,
        \Magento\Directory\Model\Data\RegionInformationFactory $regionInformationFactory,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \ZeroGravity\Directory\Model\Data\CityInformationFactory $cityInformationFactory,
        \ZeroGravity\Directory\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory,
        RegionInformationExtensionFactory $regionInformationExtensionFactory,
        CountryInformationExtensionFactory $countryInformationExtensionFactory

    )
    {
        parent::__construct(
            $countryInformationFactory,
            $regionInformationFactory,
            $directoryHelper,
            $scopeConfig,
            $storeManager
        );
        $this->cityInformationFactory = $cityInformationFactory;
        $this->cityCollectionFactory = $cityCollectionFactory;
        $this->regionInformationExtensionFactory = $regionInformationExtensionFactory;
        $this->countryInformationExtensionFactory = $countryInformationExtensionFactory;

    }


    /**
     * Creates and initializes the information for \Magento\Directory\Model\Data\CountryInformation
     *
     * @param \Magento\Directory\Model\ResourceModel\Country $country
     * @param array $regions
     * @param string $storeLocale
     * @return \Magento\Directory\Model\Data\CountryInformation
     */
    protected function setCountryInfo($country, $regions, $storeLocale)
    {
        $countryId = $country->getCountryId();

        $countryInfo = $this->countryInformationFactory->create();
        $countryInfo->setId($countryId);
        $countryInfo->setTwoLetterAbbreviation($country->getData('iso2_code'));
        $countryInfo->setThreeLetterAbbreviation($country->getData('iso3_code'));
        $countryInfo->setFullNameLocale($country->getName($storeLocale));
        $countryInfo->setFullNameEnglish($country->getName('en_US'));

        if (array_key_exists($countryId, $regions)) {
            $regionsInfo = [];
            foreach ($regions[$countryId] as $id => $regionData) {
                $regionInfo = $this->regionInformationFactory->create();
                if (!isset($regionData['code'])) continue;
                $regionInfo->setId($id);
                $regionInfo->setCode($regionData['code']);
                $regionInfo->setName($regionData['name']);
                if(isset($regionData['city'])) {
                    $extensionAttributes = $regionInfo->getExtensionAttributes();
                    $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->regionInformationExtensionFactory->create();
                    $extensionAttributes->setCity($regionData['city']);
                    $regionInfo->setExtensionAttributes($extensionAttributes);
                }
                $regionsInfo[] = $regionInfo;
            }
            $countryInfo->setAvailableRegions($regionsInfo);

        }

        $collection = $this->cityCollectionFactory->create();
        $cityes = $collection->addCountryFilter($countryId)->load();

        if (count($cityes) > 0) {
            $citysInfo = [];
            foreach ($cityes as $city) {
                $cityInfo = $this->cityInformationFactory->create();
                $cityInfo->setId($city->getCityId());
                $cityInfo->setCode($city->getCode());
                $cityInfo->setName($city->getName());
                $cityInfo->setCountryId($city->getCountryId());
                $citysInfo[] = $cityInfo;
            }
            //$citysInfo= (string)$citysInfo;
            $extensionAttributesCountry = $countryInfo->getExtensionAttributes();
            $extensionAttributesCountry = $extensionAttributesCountry ? $extensionAttributesCountry : $this->countryInformationExtensionFactory->create();
            $extensionAttributesCountry->setAvailableCity($citysInfo);
            $countryInfo->setExtensionAttributes($extensionAttributesCountry);
        }
        return $countryInfo;
    }
}
