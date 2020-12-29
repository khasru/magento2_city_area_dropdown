<?php
/**
 * Created by PhpStorm.
 * User: khasru
 * Date: 12/2/18
 * Time: 2:11 PM
 */

namespace ZeroGravity\Directory\Plugin\Directory\ResourceModel\Region;


class Options
{
    public function aroundToOptionArray(
        \Magento\Directory\Model\ResourceModel\Region\Collection $subject,
        $result
    )
    {


        $options = [];
        $propertyMap = [
            'value' => 'region_id',
            'title' => 'default_name',
            'country_id' => 'country_id',
            'city' => 'city',
        ];

        foreach ($subject as $item) {
            if ($item->getCountryId() != 'BD') continue;

            $option = [];
            foreach ($propertyMap as $code => $field) {
                $option[$code] = $item->getData($field);
            }
            $option['label'] = $item->getName();
            $options[] = $option;
        }
        if (count($options) > 0) {
            array_unshift(
                $options,
                ['title' => '', 'value' => '', 'label' => __('Please select an area.')]
            );
        }
        return $options;
    }
}