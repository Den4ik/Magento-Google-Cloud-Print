<?php
/**
 * Google Cloud Print
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * This program is provided to you AS-IS.  There is no warranty.  It has not been
 * certified for any particular purpose.
 *
 * @package    Google Cloud Print
 * @author     Denis Kopylov <dv.kopylov@snowcode.info>
 * @copyright  Copyright (c) 2014 Snowcode (http://snowcode.info/)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
require_once(Mage::getBaseDir('code') . DS . 'core' . DS . 'Mage' . DS . 'Adminhtml' . DS . 'controllers' . DS . 'Sales' . DS . 'Order' . DS . 'ShipmentController.php');

class Snowcode_GoogleCloudPrint_Adminhtml_Sales_Order_ShipmentController extends Mage_Adminhtml_Sales_Order_ShipmentController
{
    /**
     * Print shipment action
     *
     * @return void
     */
    public function printAction()
    {

        if ($shipmentId = $this->getRequest()->getParam('invoice_id')) {
            if ($shipment = Mage::getModel('sales/order_shipment')->load($shipmentId)) {
                $configHelper = Mage::helper('scgooglecloudprint/config');
                $storeId = $this->getRequest()->getParam('store') ?
                    $this->getRequest()->getParam('store') : Mage::app()->getStore()->getId();
                if ($configHelper->isShipment($storeId)) {
                    /** We should use custom pdf model with times font. Different fonts not allowed in google */
                    $pdf = Mage::getModel('scgooglecloudprint/sales_order_pdf_shipment')->getPdf(array($shipment));
                    $name = 'packingslip' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s')
                        . '_' . $shipment->getIncrementId() . '.pdf';
                    $connector = Mage::helper('scgooglecloudprint/connector');
                    $result = $connector->submit($pdf->render(), 'application/pdf', $name);
                    if ($result) {
                        Mage::getSingleton('adminhtml/session')->addSuccess(
                            Mage::helper('scgooglecloudprint')->__('Shipment successfully sent to Google Cloud Print')
                        );
                        $this->_redirect('*/*/view', array('shipment_id' => $shipmentId));
                        return;
                    }
                }

                $pdf = Mage::getModel('sales/order_pdf_shipment')->getPdf(array($shipment));
                $this->_prepareDownloadResponse('packingslip' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s') . '.pdf', $pdf->render(), 'application/pdf');
            }
        } else {
            $this->_forward('noRoute');
        }
    }
}