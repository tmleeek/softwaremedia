<?php
/**
 * Checkout Fields Manager
 *
 * @category:    Aitoc
 * @package:     Aitoc_Aitcheckoutfields
 * @version      10.5.7
 * @license:     grDwoQqpctpZdS57isl8WpY91kLDyrRZ7i5S4ZKTe1
 * @copyright:   Copyright (c) 2015 AITOC, Inc. (http://www.aitoc.com)
 */
class Aitoc_Aitcheckoutfields_Block_Rewrite_FrontCustomerFormRegister extends Mage_Customer_Block_Form_Register
{
    protected $_mainModel;
    
    protected function _construct()
    {
        parent::_construct();
        $this->_mainModel = Mage::getModel('aitcheckoutfields/aitcheckoutfields');
    }
    
    protected function _prepareLayout()
    {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setCanLoadCalendarJs(true);
        }
        return parent::_prepareLayout();
    }
    
    public function getCustomFieldsList($placeholder)
    {
        return $this->_mainModel->getCustomerAttributeList($placeholder);
    }
    
    public function getAttributeHtml($aField, $sSetName, $sPageType)
    {
        return $this->_mainModel->getAttributeHtml($aField, $sSetName, $sPageType);
    }
}