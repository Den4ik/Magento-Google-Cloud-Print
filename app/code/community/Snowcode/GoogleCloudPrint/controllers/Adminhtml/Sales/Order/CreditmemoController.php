<?php

/**
 * Google Cloud Print
 *
 * NOTICE OF LICENSE
 *
 * Copyright 2014 Profit Soft (http://profit-soft.pro/)
 *
 * Licensed under the Apache License, Version 2.0 (the “License”);
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an “AS IS” BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations under the License.
 *
 * @package   Google Cloud Print
 * @author    Denis Kopylov <dv.kopylov@profit-soft.pro>
 * @copyright Copyright (c) 2014 Profit Soft (http://profit-soft.pro/)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0 (Apache-2.0)
 */
require_once(Mage::getBaseDir('code') . DS . 'core' . DS . 'Mage' . DS . 'Adminhtml' . DS . 'controllers' . DS . 'Sales' . DS . 'Order' . DS . 'CreditmemoController.php');

class Snowcode_GoogleCloudPrint_Adminhtml_Sales_Order_CreditmemoController extends Mage_Adminhtml_Sales_Order_CreditmemoController
{
    /**
     * Print creditmemo action
     *
     * @return void
     */
    public function printAction()
    {
        if ($creditmemoId = $this->getRequest()->getParam('creditmemo_id')) {
            if ($creditmemo = Mage::getModel('sales/order_creditmemo')->load($creditmemoId)) {
                $configHelper = Mage::helper('scgooglecloudprint/config');
                $storeId = $this->getRequest()->getParam('store') ?
                    $this->getRequest()->getParam('store') : Mage::app()->getStore()->getId();
                if ($configHelper->isCreditmemo($storeId)) {
                    /** We should use custom pdf model with times font. Different fonts not allowed in google */
                    $pdf = Mage::getModel('scgooglecloudprint/sales_order_pdf_creditmemo')->getPdf(array($creditmemo));
                    $name = 'creditmemo' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s')
                        . '_' . $creditmemo->getIncrementId() . '.pdf';
                    $connector = Mage::helper('scgooglecloudprint/connector');
                    $result = $connector->submit($pdf->render(), 'application/pdf', $name);
                    if ($result) {
                        Mage::getSingleton('adminhtml/session')->addSuccess(
                            Mage::helper('scgooglecloudprint')->__('Creditmemo successfully sent to Google Cloud Print')
                        );
                        $this->_redirect('*/*/view', array('creditmemo_id' => $creditmemoId));
                        return;
                    }
                }
                $pdf = Mage::getModel('sales/order_pdf_creditmemo')->getPdf(array($creditmemo));
                $this->_prepareDownloadResponse('creditmemo' . Mage::getSingleton('core/date')->date('Y-m-d_H-i-s') .
                    '.pdf', $pdf->render(), 'application/pdf');
            }
        } else {
            $this->_forward('noRoute');
        }
    }
}