<?php
/**
 * Created by PhpStorm.
 * User: khasru
 * Date: 12/6/18
 * Time: 10:23 AM
 */

namespace ZeroGravity\Directory\Block\Adminhtml\Order\Address;


class Form extends \Magento\Sales\Block\Adminhtml\Order\Address\Form
{
    /**
     * Prepare Form and add elements to form
     *
     * @return $this
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
  /*  protected function _prepareForm()
    {
        return parent::_prepareForm();
    }*/

    /**
     * Return array of additional form element renderers by element id
     *
     * @return array
     */
    protected function _getAdditionalFormElementRenderers()
    {
        return [
            'region' => $this->getLayout()->createBlock(
                \Magento\Customer\Block\Adminhtml\Edit\Renderer\Region::class
            ),
            'city' => $this->getLayout()->createBlock(
                \ZeroGravity\Directory\Block\Adminhtml\Edit\Renderer\City::class
            )
        ];
    }

}