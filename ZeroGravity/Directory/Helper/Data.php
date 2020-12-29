<?php
/**
 * Created by PhpStorm.
 * User: khasru
 * Date: 11/14/18
 * Time: 2:10 PM
 */

namespace ZeroGravity\Directory\Helper;


class Data extends \Magento\Directory\Helper\Data
{
    protected $cityCollectionFactory;
    protected $_cityCollection;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Cache\Type\Config $configCacheType
     * @param \Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection
     * @param \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regCollectionFactory,
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Directory\Model\CurrencyFactory $currencyFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Directory\Model\ResourceModel\Country\Collection $countryCollection,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regCollectionFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \ZeroGravity\Directory\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory
    ) {
        parent::__construct(
            $context,
            $configCacheType,
            $countryCollection,
            $regCollectionFactory,
            $jsonHelper,
            $storeManager,
            $currencyFactory
            );
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    /**
     * Retrieve regions data
     *
     * @return array
     */
    public function getRegionData()
    {
        $countryIds = [];
        foreach ($this->getCountryCollection() as $country) {
            $countryIds[] = $country->getCountryId();
        }
        $collection = $this->_regCollectionFactory->create();
        $collection->addCountryFilter($countryIds)->load();
        $regions = [
            'config' => [
                'show_all_regions' => $this->isShowNonRequiredState(),
                'regions_required' => $this->getCountriesWithStatesRequired(),
            ],
        ];
        foreach ($collection as $region) {
            /** @var $region \Magento\Directory\Model\Region */
            if (!$region->getRegionId()) {
                continue;
            }
            $regions[$region->getCountryId()][$region->getRegionId()] = [
                'code' => $region->getCode(),
                'name' => (string)__($region->getName()),
                'city' => (string)__($region->getCity())
            ];
        }
        return $regions;
    }


    public function getCityOptions($countryId,$cityCode="")
    {
        $options = null;
       $cities = $this->getCityCollection($countryId);
        foreach ($cities as $city) {
            $selected="";
            if($cityCode==$city->getCode()){
               $selected='selected="selected"';
            }
            $options .= '<option value="' . $city->getCode() . '" '.$selected.' >' . $city->getName() . '</option>';
        }
        return $options;

    }

    /**
     * Retrieve city collection
     *
     * @return \ZeroGravity\Directory\Model\ResourceModel\City\Collection
     */
    public function getCityCollection($countryId)
    {
        if (!$this->_cityCollection) {
            $this->_cityCollection = $this->cityCollectionFactory->create();
            $this->_cityCollection->addCountryFilter($countryId)->load();
        }
        return $this->_cityCollection;
    }

}