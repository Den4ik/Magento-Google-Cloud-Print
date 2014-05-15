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
