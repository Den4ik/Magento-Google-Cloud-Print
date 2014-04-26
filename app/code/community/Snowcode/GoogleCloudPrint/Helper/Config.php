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
class Snowcode_GoogleCloudPrint_Helper_Config extends Mage_Core_Helper_Abstract
{
    /**
     *
     */
    const XML_API_LOGIN = 'scgooglecloudprint/general/account_login';

    /**
     *
     */
    const XML_API_PASSWORD = 'scgooglecloudprint/general/account_password';

    /**
     *
     */
    const XML_API_PRINTER_ID = 'scgooglecloudprint/general/printer_id';

    /**
     *
     */
    const XML_PRINT_INVOICE = 'scgooglecloudprint/print_replace/print_invoice';

    /**
     *
     */
    const XML_PRINT_CREDITMEMO = 'scgooglecloudprint/print_replace/print_creditmemo';

    /**
     *
     */
    const XML_PRINT_SHIPMENT = 'scgooglecloudprint/print_replace/print_shipment';

    /**
     * Is print invoice
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function isInvoice($storeId = null)
    {
        if (!is_null($storeId)) {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_INVOICE, $storeId);
        } else {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_INVOICE);
        }
    }

    /**
     * Is print creditmemo
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function isCreditmemo($storeId = null)
    {
        if (!is_null($storeId)) {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_CREDITMEMO, $storeId);
        } else {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_CREDITMEMO);
        }
    }

    /**
     * Is print shipment
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function isShipment($storeId = null)
    {
        if (!is_null($storeId)) {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_SHIPMENT, $storeId);
        } else {
            return (bool)Mage::getStoreConfig(self::XML_PRINT_SHIPMENT);
        }
    }

    /**
     * Get google API login
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function getAccountLogin($storeId = null)
    {
        if (!is_null($storeId)) {
            return Mage::getStoreConfig(self::XML_API_LOGIN, $storeId);
        } else {
            return Mage::getStoreConfig(self::XML_API_LOGIN);
        }
    }

    /**
     * Get google API password
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function getAccountPassword($storeId = null)
    {
        if (!is_null($storeId)) {
            return Mage::getStoreConfig(self::XML_API_PASSWORD, $storeId);
        } else {
            return Mage::getStoreConfig(self::XML_API_PASSWORD);
        }
    }

    /**
     * Get google printer id
     *
     * @param null $storeId Store id
     * @return bool
     */
    public function getPrinterId($storeId = null)
    {
        if (!is_null($storeId)) {
            return Mage::getStoreConfig(self::XML_API_PRINTER_ID, $storeId);
        } else {
            return Mage::getStoreConfig(self::XML_API_PRINTER_ID);
        }
    }
}
