<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ZeroGravity\Directory\Model;

/**
 * City
 *
 * @api
 * @since 100.0.2
 */
class City extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\ZeroGravity\Directory\Model\ResourceModel\City::class);
    }
}
