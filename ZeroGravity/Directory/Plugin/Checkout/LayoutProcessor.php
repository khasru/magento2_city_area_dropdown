<?php

namespace ZeroGravity\Directory\Plugin\Checkout;

class LayoutProcessor
{
    protected $cityCollectionFactory;

    public function __construct(\ZeroGravity\Directory\Model\ResourceModel\City\CollectionFactory $cityCollectionFactory)
    {
        $this->cityCollectionFactory = $cityCollectionFactory;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        $jsLayout
    )
    {
        $jsLayout = $this->shippingAddressProcess($jsLayout);
        $jsLayout = $this->billingAddressProcess($jsLayout);

        return $jsLayout;
    }

    private function shippingAddressProcess($jsLayout)
    {
        // Hide the field
        $visibility = [
            'visible' => false
        ];
        // Change in shipping address

        $city = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['city'];

        $city['config']['elementTmpl'] = 'ui/form/element/select';
        $city['component'] = 'ZeroGravity_Directory/js/city';
        //$city['options'] = array(array('value'=>'Dhaka','label'=>'Dahaka'),array('value'=>'Comilla  ','label'=>'comilla'));
        $city['options'] = $this->getCityOptions();
        $region = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['region_id'];

        $country = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
        ['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['country_id'];

        $country = array_merge($country, $visibility);
        return $jsLayout;
    }

    private function billingAddressProcess($jsLayout)
    {
        // Hide the field
        $visibility = [
            'visible' => false
        ];

        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children'])) {
            $city = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['city'];

            $country = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['afterMethods']['children']['billing-address-form']['children']['form-fields']['children']['country_id'];
        } else {
            $city = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['payments-list']['children']['checkmo-form']['children']['form-fields']
            ['children']['city'];
            $country = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
            ['children']['payment']['children']['payments-list']['children']['checkmo-form']['children']['form-fields']
            ['children']['country_id'];
        }

        $country = array_merge($country, $visibility);

        $city['config']['elementTmpl'] = 'ui/form/element/select';
        $city['component'] = 'ZeroGravity_Directory/js/city';
        $city['options'] = $this->getCityOptions();
        return $jsLayout;
    }

    public function getCityOptions()
    {
        $this->_cityCollection = $this->cityCollectionFactory->create();
        return $options = $this->_cityCollection->toOptionArray();
    }
}