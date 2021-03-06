<?php

class OCM_Quotedispatch_Block_Adminhtml_Quotedispatch_Grid extends Mage_Adminhtml_Block_Widget_Grid {

	public function __construct() {
		parent::__construct();
		$this->setId('quotedispatchGrid');
		$this->setDefaultSort('quotedispatch_id');
		$this->setDefaultDir('ASC');
		$this->setDefaultFilter(array('in_products' => 1));
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection() {
		$collection = Mage::getModel('quotedispatch/quotedispatch')->getCollection()
			->addFirstLastNameToSelect()
			->addQuoteSubtotal()
		;
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _afterLoadCollection() {
		$collection = $this->getCollection();
		foreach ($collection as $item) {
			$item->getItemList();
		}
		return parent::_afterLoadCollection();
	}

	protected function _prepareColumns() {

// if (!$this->hasData('all_items')) {
//
//            $name_attr = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'name');
		$collection = Mage::getModel('quotedispatch/quotedispatch')->getCollection()->getData();
		$itemscollection = Mage::getModel('quotedispatch/quotedispatch_items')->getCollection()->getData();

		$this->addColumn('quotedispatch_id', array(
			'header' => Mage::helper('quotedispatch')->__('ID'),
			'align' => 'right',
			'width' => '50px',
			'index' => 'quotedispatch_id',
		));

//      $this->addColumn('title', array(
//          'header'    => Mage::helper('quotedispatch')->__('Quote Name'),
//          'align'     =>'left',
//          'index'     => 'title',
//      ));

		$this->addColumn('first_last_name', array(
			'header' => Mage::helper('quotedispatch')->__('Name'),
			'align' => 'left',
			'index' => 'first_last_name',
			'filter_condition_callback' => array($this, 'addConcatToFilter'),
		));

		$this->addColumn('company', array(
			'header' => Mage::helper('quotedispatch')->__('Company'),
			'align' => 'left',
			'index' => 'company',
		));

		$this->addColumn('email', array(
			'header' => Mage::helper('quotedispatch')->__('Email'),
			'align' => 'left',
			'index' => 'email',
		));

		$this->addColumn('item_list', array(
			'header' => Mage::helper('quotedispatch')->__('products'),
			'align' => 'left',
			'index' => 'item_list',
			'type' => 'text',
			'filter' => false,
			'sortable' => false
		));

		$this->addColumn('total', array(
			'header' => Mage::helper('catalog')->__('Total'),
			'type' => 'price',
			'name' => 'subtotal',
			//               'currency_code' => $store->getBaseCurrency()->getCode(),
			'editable' => 1,
			'index' => 'subtotal',
			'filter' => false,
		));

		$this->addColumn('created_time', array(
			'header' => Mage::helper('quotedispatch')->__('Created Time'),
			'index' => 'created_time',
			'type' => 'date',
			'width' => '100px',
		));

		$this->addColumn('expire_time', array(
			'header' => Mage::helper('quotedispatch')->__('Expires'),
			'index' => 'expire_time',
			'type' => 'date',
			'width' => '100px',
		));

		$this->addColumn('status', array(
			'header' => Mage::helper('quotedispatch')->__('Status'),
			'align' => 'left',
			'width' => '80px',
			'index' => 'status',
			'type' => 'options',
			'options' => Mage::getModel('quotedispatch/status')->getOptionArray(),
		));

		$this->addColumn('created_by', array(
			'header' => Mage::helper('quotedispatch')->__('Sales Rep'),
			'align' => 'left',
			'width' => '80px',
			'index' => 'created_by',
			'type' => 'options',
			'options' => Mage::getModel('quotedispatch/adminuser')->getOptionArray(),
		));

		$this->addExportType('*/*/exportCsv', Mage::helper('quotedispatch')->__('CSV'));
		$this->addExportType('*/*/exportExcel', Mage::helper('quotedispatch')->__('Excel XML'));

		return parent::_prepareColumns();
	}

	protected function _prepareMassaction() {
		$this->setMassactionIdField('quotedispatch_id');
		$this->getMassactionBlock()->setFormFieldName('quotedispatch');

		$this->getMassactionBlock()->addItem('delete', array(
			'label' => Mage::helper('quotedispatch')->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => Mage::helper('quotedispatch')->__('Are you sure?')
		));

		return $this;
	}

	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

	// Callback function converts first_last_name to CONCAT to culomn for select
	public function addConcatToFilter($collection, $column) {

		if (!$column->getFilter()->getCondition()) {
			return;
		}
		$condition = $collection->getConnection()
			->prepareSqlCondition('CONCAT(firstname," ",lastname)', $column->getFilter()->getCondition());
		$collection->getSelect()->where($condition);
	}

}

//class OCM_Quotedispatch_Block_Adminhtml_Quotedispatch_Grid_Renderer_Subtotal
//    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
//{
//    public function render(Varien_Object $row)
//    {
//        $value = $row->getData('price');
//
//        return $value;
//    }
//}