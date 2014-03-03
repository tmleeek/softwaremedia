<?php
/*
* ModifyMage Solutions (http://ModifyMage.com)
* Serial Codes - Serial Numbers, Product Codes, PINs, and More
*
* NOTICE OF LICENSE
* This source code is owned by ModifyMage Solutions and distributed for use under the
* provisions, terms, and conditions of our Commercial Software License Agreement which
* is bundled with this package in the file LICENSE.txt. This license is also available
* through the world-wide-web at this URL: http://www.modifymage.com/software-license
* If you do not have a copy of this license and are unable to obtain it through the
* world-wide-web, please email us at license@modifymage.com so we may send you a copy.
*
* @category		Mmsmods
* @package		Mmsmods_Serialcodes
* @author		David Upson
* @copyright	Copyright 2013 by ModifyMage Solutions
* @license		http://www.modifymage.com/software-license
*/

class Mmsmods_Serialcodes_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup
{
    public function getDefaultEntities()
    {
        return array(
            'catalog_product' => array(
                'entity_model'      			=> 'catalog/product',
                'attribute_model'   			=> 'catalog/resource_eav_attribute',
                'table'             			=> 'catalog/product',
				'additional_attribute_table'	=> 'catalog/eav_attribute',
				'entity_attribute_collection'	=> 'catalog/product_attribute_collection',
                'attributes'        			=> array(
                    'serial_code_invoiced' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Issue When Invoiced',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 1,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Enable automatic issuing of codes to order when invoiced and paid.'
					),
                    'serial_code_serialized' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Issue On Checkout',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 2,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Enable automatic issuing of codes to order on successful checkout.'
					),
                    'serial_code_use_customer' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Issue By Customer Group',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 3,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Enable automatic issuing of codes based on customer group.'
					),
                    'serial_code_customer_groups' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => 'serialcodes/product_customer_groups_backend',
                        'frontend'          => '',
                        'label'             => 'Select Customer Groups',
                        'input'             => 'multiselect',
                        'class'             => '',
                        'source'            => 'serialcodes/product_customer_groups',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 4,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Customers in selected groups will be issued codes automatically when product is ordered.'
					),
                    'serial_code_pool' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Code Pool (SKU)',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
                        'sort_order'		=> 5,
                        'unique'            => false,
						'note'				=> 'Leave empty to use product SKU.'
					),
                    'serial_code_type' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Serial Code Type',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 6,
                        'unique'            => false,
						'note'				=> 'Use the singular form (e.g. Serial Number, Username | Password, Activation Key). Defaults to "Serial Code" if left empty.'
					),
                    'serial_code_not_available' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Not Available Message',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => 'Oops! Please call or email.',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 7,
                        'unique'            => false,
						'note'				=> 'Message displayed to customer when no codes are available to issue. Defaults to "Oops! Not available." if left empty.'
					),
                    'serial_code_update_stock' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Update Inventory Stock',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 8,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Keep inventory stock quantity updated based on number of codes available to issue.'
					),
                    'serial_code_show_order' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Show On Customer Order',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 9,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Display issued codes on order in frontend for registered customers.'
					),
                    'serial_code_send_email' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Send Customer Email',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 10,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Deliver codes to customer when they are automatically issued.'
					),
                    'serial_code_use_voucher' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Send As Voucher',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 11,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Deliver each issued code in a separate email.'
					),
                    'serial_code_email_template' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Delivery Email Template',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'serialcodes/product_email_templates',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => 'serialcodes_delivery',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 12,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Email template to use for delivering codes to customer.'
					),
                    'serial_code_email_type' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Email Type',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 13,
                        'unique'            => false,
						'note'				=> 'Displayed in checkout success message and optionally within delivery email (e.g. Instructions, Warranty, Rules)'
					),
                    'serial_code_send_copy' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Email Blind Copy To',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 14,
                        'unique'            => false,
						'note'				=> 'Separate each provided email address with spaces (do not use commas, semicolons, or other delimiters).'
					),
                    'serial_code_low_warning' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Send Low Warning Email',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'eav/entity_attribute_source_boolean',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 15,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Send warning message by email when remaining codes are getting low.'
					),
                    'serial_code_warning_template' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Low Warning Template',
                        'input'             => 'select',
                        'class'             => '',
                        'source'            => 'serialcodes/product_email_templates',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => 'serialcodes_warning',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 16,
                        'unique'            => false,
						'is_configurable'	=> false,
						'note'				=> 'Email template to use for the warning message.'
					),
                    'serial_code_warning_level' => array(
						'group'             => 'Serial Codes',
						'type'              => 'int',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Low Warning Level',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '0',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 17,
                        'unique'            => false,
						'note'				=> 'Notify when remaining codes reaches this number.'
					),
                    'serial_code_send_warning' => array(
						'group'             => 'Serial Codes',
						'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Email Low Warning To',
                        'input'             => 'text',
                        'class'             => '',
                        'source'            => '',
                        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true,
                        'default'           => '',
                        'searchable'        => false,
                        'filterable'        => false,
                        'comparable'        => false,
                        'visible_on_front'  => false,
						'sort_order'		=> 18,
                        'unique'            => false,
						'note'				=> 'Separate each provided email address with spaces (do not use commas, semicolons, or other delimiters).'
					)
				)
			),
			'order_item' => array(
                'entity_model'      => 'sales/order_item',
                'table'             => 'sales/order_entity',
                'attributes'        => array(
                    'serial_code_type' => array(
                        'type'              => 'varchar',
                        'label'             => 'Serial Code Type',
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true
					),
                     'serial_codes' => array(
                        'type'              => 'text',
                        'label'             => 'Serial Codes',
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true
					),
                     'serial_code_ids' => array(
                        'type'              => 'text',
                        'label'             => 'Serial Code Ids',
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true
					),
                     'serial_codes_issued' => array(
                        'type'              => 'int',
                        'label'             => 'Serial Codes Issued',
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true
					),
                    'serial_code_pool' => array(
                        'type'              => 'varchar',
                        'label'             => 'Serial Code Pool',
                        'visible'           => true,
                        'required'          => false,
                        'user_defined'      => true
					)
				)
			)
		);
	}
}