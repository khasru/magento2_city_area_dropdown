<?php
/**
 * Created by PhpStorm.
 * User: khasru
 * Date: 12/5/18
 * Time: 6:13 PM
 */

namespace ZeroGravity\Directory\Block\Adminhtml\Edit\Renderer;


/**
 * Customer address city field renderer
 */
class City extends \Magento\Backend\Block\AbstractBlock implements
    \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $_directoryHelper;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \ZeroGravity\Directory\Helper\Data $directoryCityHelper,
        array $data = []
    )
    {
        $this->_directoryHelper = $directoryCityHelper;
        parent::__construct($context, $data);
    }

    /**
     * Output the region element and javasctipt that makes it dependent from country element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $countryHtmlId="";
        if ($country = $element->getForm()->getElement('country_id')) {
            $countryHtmlId= "#".$country->getHtmlId();
            $countryId = $country->getValue();
            $country->addClass('hidden');
        } else {
            return $element->getDefaultHtml();
        }
        $_cityValue = $element->getForm()->getElement('city')->getValue();
        if (empty($_cityValue)) {
            $_cityValue = "Dhaka";
        }
        if (empty($countryId)) {
            $countryId = "BD";
        }

        $cityOptions = $this->_directoryHelper->getCityOptions($countryId ,$_cityValue);
        $cityId = $element->getForm()->getElement('city')->getValue();

        $html = '<div class="field field-state required admin__field _required">';
        $element->setClass('input-text admin__control-text');
        $element->setRequired(true);
        $html .= $element->getLabelHtml() . '<div class="control admin__field-control">';
        //$html .= $element->getElementHtml();

        $selectName = str_replace('city', 'city', $element->getName());
        //$selectId = $element->getHtmlId() . '_id';
        $selectId = $element->getHtmlId();
        $html .= '<select id="' .
            $selectId .
            '" name="' .
            $selectName .
            '" class="select required-entry admin__control-select city-select">';
        $html .= '<option value="">' . __('Please select') . '</option>';
        $html .= $cityOptions;
        $html .= '</select>';

        if($countryHtmlId) {
            $html .= '<script>' . "\n";
            $html .= 'require(["jquery"], function(){';
            $html .= ' jQuery("'.$countryHtmlId.'").closest(".field-country_id").hide();' . "\n";
            $html .= '});';
            $html .= '</script>' . "\n";
        }

        $html .= '</div></div>' . "\n";

        return $html;
    }
}