<?php
class EmjaInteractive_Accountreceivable_Block_Adminhtml_Accountreceivable_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function getCsv()
	{
		$csv	= '';
		$ar		= new EmjaInteractive_Accountreceivable_Block_Adminhtml_Accountreceivable();
		
		$company_name = $this->getRequest()->getParam('company_name');
		$from = $this->getRequest()->getParam('from');
		$to = $this->getRequest()->getParam('to');
		$po = $this->getRequest()->getParam('po');
		$net = $this->getRequest()->getParam('net');
		$order = $this->getRequest()->getParam('order');
		$pt = $this->getRequest()->getParam('pt');
		
		$fromFormatted = NULL;
		$toFormatted = NULL;
		
		if($from != '')	$fromFormatted	= date('Y-m-d', strtotime($from));
		if($to != '')	$toFormatted	= date('Y-m-d', strtotime($to));
		
		Zend_Date::setOptions(array('format_type' => 'php'));
		
		$data	= array();
		$data[] = '"Transaction Number"';
		$data[] = '"Transaction Type"';
		$data[] = '"Transaction Date"';
		$data[] = '"Company"';
		$data[] = '"Purchase Order Number"';
		$data[] = '"Due Date"';
		$data[] = '"Days Past Due"';
		$data[] = '"Terms"';
		$data[] = '"Transaction Amount"';
		$data[] = '"Discount"';
		$data[] = '"Open Amount"';
		$data[] = '"Payment Method"';
		$data[] = '"Notes"';
		
		$csv .= implode(',', $data)."\n";
		
		$poNumbers = array();
		$allOrderCollection = $ar->getAllOrderCollection();
		foreach($allOrderCollection as $allOrder) {
			$poNumbers[$allOrder->getId()] = $allOrder->getPoNumber();
		}
		
		$orderCollection = $ar->getOrderCollection($fromFormatted, $toFormatted, $po, $net, $order, $pt);
		$creditmemoCollection = $ar->getCreditMemoCollection($fromFormatted, $toFormatted, $po, $net, $order);
		$invoiceCollection = $ar->getInvoiceCollection($fromFormatted, $toFormatted, $po, $net, $order);

		if(count($orderCollection)) {
			$customerModel = Mage::getModel('customer/customer');
			$addressModel = Mage::getModel('customer/address');
			
			foreach($orderCollection as $order) {
				if($order->getBillingAddress()->getCompany() and $company_name != '' and $company_name != 'all' and $order->getBillingAddress()->getCompany() != $company_name) continue;
				
				$orderDetails = Mage::getSingleton('sales/order')->load($order->getId());
				$orderCompany = '';
				if($order->getCustomerId() == NULL) {
					$orderCompany = $order->getBillingAddress()->getCompany();
					if(($company_name != '' and $company_name != 'all') and $order->getBillingAddress()->getCompany() != $company_name) {
						continue;
					}
				} elseif($order->getCustomerId()) {
					$customer = $customerModel->load($order->getCustomerId());
					$billingAddress = $customer->getDefaultBilling();
					if($billingAddress) {
						$address = $addressModel->load($billingAddress);
						$orderCompany = $address->getCompany();
						if(($company_name != '' and $company_name != 'all') and $address->getCompany() != $company_name)
						continue;
					}
				}
				
				$orderDueDate = '';
				$netTerms = $order->getNetTerms();
				if(!empty($netTerms)) {
					$shipmentDate = NULL;
					foreach($order->getShipmentsCollection() as $shipment) {
						$shipmentDate = $shipment->getCreatedAt();
						break;
					}
					
					if($shipmentDate) {
						$date = new Zend_Date($shipmentDate, 'Y-m-d');
						$date->addDay(30); //$date->addDay($netTerms);
						$orderDueDate = $date->get('n/j/Y');
					} else {
						$date = new Zend_Date($order->getCreatedAt(), 'Y-m-d');
						$date->addDay(30); //$date->addDay($netTerms);
						$orderDueDate = $date->get('n/j/Y');
					}
				} else {
					$shipmentDate = NULL;
					foreach($order->getShipmentsCollection() as $shipment) {
						$shipmentDate = $shipment->getCreatedAt();
						break;
					}
					
					if($shipmentDate) {
						$date = new Zend_Date($shipmentDate, 'Y-m-d');
						$orderDueDate = $date->get('n/j/Y');
					} else {
						$date = new Zend_Date($order->getCreatedAt(), 'Y-m-d');
						$orderDueDate = $date->get('n/j/Y');
					}
				}
				
				$orderDaysPastDue = '';
				$today = new Zend_Date();
				$diff = $today->sub($date)->toValue();
				$orderDaysPastDue = ceil($diff/60/60/24) - 1;
				
				if($orderDaysPastDue <= 0)
					$orderDaysPastDue = '';
				
				if(!empty($netTerms))
					$netTerms = 'NET ' . $netTerms;
				
				$data	= array();
				$data[] = '"'.$order->getIncrementId().'"';
				$data[] = '"Purchase Order"';
				$data[] = '"'.date('n/j/Y', strtotime($order->getCreatedAt())).'"';
				$data[] = $orderCompany ? '"'.$orderCompany .'"' : '"'.$order->getBillingAddress()->getCompany().'"';
				$data[] = '"'.$order->getPoNumber().'"';
				$data[] = '"'.$orderDueDate.'"';
				$data[] = '"'.$orderDaysPastDue.'"';
				$data[] = '"'.$netTerms.'"';
				$data[] = '"'.Mage::helper('core')->currency($order->getGrandTotal() + abs($orderDetails->getDiscountAmount()), true, false).'"';
				$data[] = '"'.abs($orderDetails->getDiscountAmount()) ? Mage::helper('core')->currency(abs($orderDetails->getDiscountAmount()), true, false) : '""' .'"';
				$data[] = '"'.Mage::helper('core')->currency($order->getGrandTotal(), true, false).'"';
				$data[] = '""';
				$data[] = '"'.Mage::helper('accountreceivable')->getTransactionNote($order->getIncrementId()).'"';

				$csv .= implode(',', $data)."\n";
			}
		
		}
		
		return $csv;
    }
	
	public function getXml()
    {
        $ar	= new EmjaInteractive_Accountreceivable_Block_Adminhtml_Accountreceivable();
		
		$company_name = $this->getRequest()->getParam('company_name');
		$from = $this->getRequest()->getParam('from');
		$to = $this->getRequest()->getParam('to');
		
		$fromFormatted = NULL;
		$toFormatted = NULL;
		
		if($from != '')	$fromFormatted	= date('Y-m-d', strtotime($from));
		if($to != '')	$toFormatted	= date('Y-m-d', strtotime($to));
		
		Zend_Date::setOptions(array('format_type' => 'php'));
		
		$poNumbers = array();
		$allOrderCollection = $ar->getAllOrderCollection();
		foreach($allOrderCollection as $allOrder) {
			$poNumbers[$allOrder->getId()] = $allOrder->getPoNumber();
		}
		
		$orderCollection = $ar->getOrderCollection($fromFormatted, $toFormatted);
		$creditmemoCollection = $ar->getCreditMemoCollection($fromFormatted, $toFormatted);
		$invoiceCollection = $ar->getInvoiceCollection($fromFormatted, $toFormatted);

		$xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml.= '<items>'."\n";

		if(count($orderCollection) or count($creditmemoCollection) or count($invoiceCollection)) {
			$customerModel = Mage::getModel('customer/customer');
			$addressModel = Mage::getModel('customer/address');
			
			foreach($orderCollection as $order) {
				if($order->getBillingAddress()->getCompany() and $company_name != '' and $company_name != 'all' and $order->getBillingAddress()->getCompany() != $company_name) continue;
				
				$orderDetails = Mage::getSingleton('sales/order')->load($order->getId());
				$orderCompany = '';
				if($order->getCustomerId() == NULL) {
					$orderCompany = $order->getBillingAddress()->getCompany();
					if(($company_name != '' and $company_name != 'all') and $order->getBillingAddress()->getCompany() != $company_name) {
						continue;
					}
				} elseif($order->getCustomerId()) {
					$customer = $customerModel->load($order->getCustomerId());
					$billingAddress = $customer->getDefaultBilling();
					if($billingAddress) {
						$address = $addressModel->load($billingAddress);
						$orderCompany = $address->getCompany();
						if(($company_name != '' and $company_name != 'all') and $address->getCompany() != $company_name)
						continue;
					}
				}
				
				$orderDueDate = '';
				$netTerms = ($order->getData('net_terms') ? $order->getData('net_terms') : '30');
				$netTerms = str_replace('NET ' ,'', $netTerms);
				if (substr($netTerms,0,3) == 'COD')
					$netTerms = '30';
								
				if(!empty($netTerms)) {
					$shipmentDate = NULL;
					foreach($order->getShipmentsCollection() as $shipment) {
						$shipmentDate = $shipment->getCreatedAt();
						break;
					}
					
						$date = new Zend_Date($order->getCreatedAt(), 'Y-m-d');
						$date->addDay($netTerms);
						$orderDueDate = $date->get('n/j/Y');
					
				} else {
					$shipmentDate = NULL;
					foreach($order->getShipmentsCollection() as $shipment) {
						$shipmentDate = $shipment->getCreatedAt();
						break;
					}

						$date = new Zend_Date($order->getCreatedAt(), 'Y-m-d');
						$orderDueDate = $date->get('n/j/Y');
					
				}
				
				$orderDaysPastDue = '';
				$today = new Zend_Date();
				$diff = $today->sub($date)->toValue();
				$orderDaysPastDue = ceil($diff/60/60/24) - 1;
				
				if($orderDaysPastDue <= 0)
					$orderDaysPastDue = '';
				
				$netTerms = ($order->getData('net_terms') ? $order->getData('net_terms') : '30');
				$netTerms = str_replace('NET ' ,'', $netTerms);
								
				if(!empty($netTerms) && substr($netTerms,0,3) != 'COD')
					$netTerms = 'NET ' . $netTerms;
				
				$data	= array();
				$data['TransactionNumber'] = $order->getIncrementId();
				$data['TransactionType'] = 'Purchase Order';
				$data['TransactionDate'] = date('n/j/Y', strtotime($order->getCreatedAt()));
				$data['Company'] = $orderCompany ? $orderCompany : $order->getBillingAddress()->getCompany();
				$data['PurchaseOrderNumber'] = $order->getPoNumber();
				$data['DueDate'] = $orderDueDate;
				$data['DaysPastDue'] = $orderDaysPastDue;
				$data['Terms'] = $netTerms;
				$data['TransactionAmount'] = Mage::helper('core')->currency($order->getGrandTotal() + abs($orderDetails->getDiscountAmount()), true, false);
				$data['Discount'] = abs($orderDetails->getDiscountAmount()) ? Mage::helper('core')->currency(abs($orderDetails->getDiscountAmount()), true, false) : '';
				$data['OpenAmount'] = Mage::helper('core')->currency($order->getGrandTotal(), true, false);
				$data['PaymentMethod'] = '';
				$data['Notes'] = Mage::helper('accountreceivable')->getTransactionNote($order->getIncrementId());

				$xml .= $this->toXml($data, 'item', false, false);
			}
		
		}
		
		$xml.= '</items>';
		
		return $xml;
    }
	
	public function toXml(array $arrAttributes = array(), $rootName = 'item', $addOpenTag=false, $addCdata=true)
    {
        return $this->__toXml($arrAttributes, $rootName, $addOpenTag, $addCdata);
    }

    protected function __toXml(array $arrAttributes = array(), $rootName = 'item', $addOpenTag=false, $addCdata=true)
    {
        $xml = '';
        if ($addOpenTag) {
            $xml.= '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        }
        if (!empty($rootName)) {
            $xml.= '<'.$rootName.'>'."\n";
        }
        $xmlModel = new Varien_Simplexml_Element('<node></node>');
        //$arrData = $this->toArray($arrAttributes);
        foreach ($arrAttributes as $fieldName => $fieldValue) {
            if ($addCdata === true) {
                $fieldValue = "<![CDATA[$fieldValue]]>";
            } else {
                $fieldValue = $xmlModel->xmlentities($fieldValue);
            }
            $xml.= "<$fieldName>$fieldValue</$fieldName>"."\n";
        }
        if (!empty($rootName)) {
            $xml.= '</'.$rootName.'>'."\n";
        }
        return $xml;
    }

    
}