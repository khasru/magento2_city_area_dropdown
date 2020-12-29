<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ZeroGravity\Directory\Api\Data;

/**
 * City Information interface.
 *
 * @api
 * @since 100.0.2
 */
interface CityInformationInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get city id
     *
     * @return string
     */
    public function getId();

    /**
     * Set city id
     *
     * @param string $cityId
     * @return $this
     */
    public function setId($cityId);

    /**
     * Get city code
     *
     * @return string
     */
    public function getCode();

    /**
     * Set city code
     *
     * @param string $cityCode
     * @return $this
     */
    public function setCode($cityCode);


    /**
     * Get Country Id
     *
     * @return string
     */
    public function getCountryId();


    /**
     * Set country Id
     *
     * @param string $countryId
     * @return $this
     */
    public function setCountryId($countryId);


    /**
     * Get city name
     *
     * @return string
     */
    public function getName();

    /**
     * Set city name
     *
     * @param string $city
     * @return $this
     */
    public function setName($cityName);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \ZeroGravity\Directory\Api\Data\CityInformationExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \ZeroGravity\Directory\Api\Data\CityInformationExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \ZeroGravity\Directory\Api\Data\CityInformationExtensionInterface $extensionAttributes
    );
}
