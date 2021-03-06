<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * admin customer left menu
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class TBT_Rewards_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {
    
	public function __construct() {
		parent::__construct ();
		$this->setId ( 'customer_info_tabs' );
		$this->setDestElementId ( 'edit_form' );
		$this->setTitle ( Mage::helper ( 'customer' )->__ ( 'Customer Information' ) );
	}
	
	//Mage_Adminhtml_Block_Customer_Edit_Tabs
	//                <rewrite>
	//                		<customer_edit_tabs>TBT_Rewards_Block_Adminhtml_Customer_Edit_Tabs</customer_edit_tabs>
	//                </rewrite>
	/**
	 * This overwrites the parent function to add the 'Points & Rewards' 
	 * tab in the edit menu for the customer.
	 * 
	 */
	protected function _beforeToHtml() {
		if (Mage::registry ( 'current_customer' )->getId ()) {
			$this->addTab ( 'view', array ('label' => Mage::helper ( 'customer' )->__ ( 'Customer View' ), 'content' => $this->getLayout ()->createBlock ( 'adminhtml/customer_edit_tab_view' )->toHtml (), 'active' => true ) );
		}
		
		$this->addTab ( 'account', array ('label' => Mage::helper ( 'customer' )->__ ( 'Account Information' ), 'content' => $this->getLayout ()->createBlock ( 'adminhtml/customer_edit_tab_account' )->initForm ()->toHtml (), 'active' => Mage::registry ( 'current_customer' )->getId () ? false : true ) );
		
		$this->addTab ( 'addresses', array ('label' => Mage::helper ( 'customer' )->__ ( 'Addresses' ), 'content' => $this->getLayout ()->createBlock ( 'adminhtml/customer_edit_tab_addresses' )->initForm ()->toHtml () ) );
		
		// load: Orders, Shopping Cart, Wishlist, Product Reviews, Product Tags - with ajax
		

		if (Mage::registry ( 'current_customer' )->getId ()) {
			$this->addTab ( 'orders', array ('label' => Mage::helper ( 'customer' )->__ ( 'Orders' ), 'class' => 'ajax', 'url' => $this->getUrl ( '*/*/orders', array ('_current' => true ) ) ) );
			
			$this->addTab ( 'cart', array ('label' => Mage::helper ( 'customer' )->__ ( 'Shopping Cart' ), 'class' => 'ajax', 'url' => $this->getUrl ( '*/*/carts', array ('_current' => true ) ) ) );
			
			$this->addTab ( 'wishlist', array ('label' => Mage::helper ( 'customer' )->__ ( 'Wishlist' ), 'class' => 'ajax', 'url' => $this->getUrl ( '*/*/wishlist', array ('_current' => true ) ) ) );
			
			$this->addTab ( 'newsletter', array ('label' => Mage::helper ( 'customer' )->__ ( 'Newsletter' ), 'content' => $this->getLayout ()->createBlock ( 'adminhtml/customer_edit_tab_newsletter' )->initForm ()->toHtml () ) );
			
			$this->addTab ( 'reviews', array ('label' => Mage::helper ( 'customer' )->__ ( 'Product Reviews' ), 'class' => 'ajax', 'url' => $this->getUrl ( '*/*/productReviews', array ('_current' => true ) ) ) );
			
			$this->addTab ( 'tags', array ('label' => Mage::helper ( 'customer' )->__ ( 'Product Tags' ), 'class' => 'ajax', 'url' => $this->getUrl ( '*/*/productTags', array ('_current' => true ) ) ) );
			
			$this->addTab ( 'rewards', array ('label' => Mage::helper ( 'customer' )->__ ( 'Points & Rewards' ), 'content' => $this->getLayout ()->createBlock ( 'rewards/manage_customer_edit_tab_main' )->toHtml () ) );
		}
		
		$this->_updateActiveTab ();
		Varien_Profiler::stop ( 'customer/tabs' );
		return parent::_beforeToHtml ();
	
		//    	$html = parent::_beforeToHtml();
	//        if (Mage::registry('current_customer')->getId()) {
	//        }
	//        
	//        $this->_updateActiveTab();
	////        Varien_Profiler::stop('customer/tabs');
	//        return $html;
	}

}

?>