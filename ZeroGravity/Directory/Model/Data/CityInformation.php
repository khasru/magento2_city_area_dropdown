<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ZeroGravity\Directory\Model\Data;

/**
 * Class Region Information
 *
 * @codeCoverageIgnore
 */
class CityInformation extends \Magento\Framework\Api\AbstractExtensibleObject implements
    \ZeroGravity\Directory\Api\Data\CityInformationInterface
{
    const KEY_CITY_ID   = 'city_id';
    const KEY_CITY_CODE = 'code';
    const KEY_CITY_NAME = 'name';

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->_get(self::KEY_CITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setId($cityId)
    {
        $this->setData(self::KEY_CITY_ID, $cityId);
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        return $this->_get(self::KEY_CITY_CODE);
    }

    /**
     * @inheritDoc
     */
    public function setCode($cityCode)
    {
        $this->setData(self::KEY_CITY_CODE, $cityCode);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->_get(self::KEY_CITY_NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName($cityName)
    {
        $this->setData(self::KEY_CITY_NAME, $cityName);
    }

    /**
     * @inheritDoc
     */
    public function getCountryId(){
        return $this->_get('country_id');
    }

    /**
     * @inheritDoc
     */
    public function setCountryId($country_id)
    {
        $this->setData('country_id', $country_id);
    }


    /**
     * @inheritDoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritDoc
     */
    public function setExtensionAttributes(
        \ZeroGravity\Directory\Api\Data\CityInformationExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
