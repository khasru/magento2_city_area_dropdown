<?php
namespace ZeroGravity\Directory\Plugin\Checkout;

//use Magento\Store\Model\StoreManagerInterface;

class DirectoryDataProcessor
{
    /**
     * @var array
     */
   // private $regionOptions;

    /**
     * @var StoreManagerInterface
     */
 //   private $storeManager;


   public function __construct(
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollection
       // StoreManagerInterface $storeManager = null

    ) {
        $this->regionCollectionFactory = $regionCollection;
     //   $this->storeManager = $storeManager ?: ObjectManager::getInstance()->get(StoreManagerInterface::class);

    }


    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessorInterface $subject,
        $jsLayout
    )
    {


       $countryOptions = &$jsLayout['components']['checkoutProvider']['dictionaries']['country_id'];
        $filteredCountryOptions = array();
        foreach ($countryOptions as $countryOption){
            if(!empty($countryOption['value']) && $countryOption['value'] != 'delimiter'){
                $filteredCountryOptions[] = $countryOption;
            }
        }
        $countryOptions = $filteredCountryOptions;
        return $jsLayout;
    }

}