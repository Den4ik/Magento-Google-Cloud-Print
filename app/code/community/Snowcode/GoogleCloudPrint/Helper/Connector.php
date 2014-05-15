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
class Snowcode_GoogleCloudPrint_Helper_Connector extends Mage_Core_Helper_Abstract
{
    /**
     * Interface url. http or https calculate by store protocol
     * @var string
     */
    private $_gcpInterfaceUrl = 'https://www.google.com/cloudprint/interface';

    /**
     * Google Cloud Print Client
     * @var null|Zend_Gdata_HttpClient
     */
    private $_gcpClient = null;

    /**
     * Google Cloud Print client setter
     *
     * @param null|\Zend_Gdata_HttpClient $gcpClient Client
     */
    public function setGcpClient($gcpClient)
    {
        $this->_gcpClient = $gcpClient;
    }

    /**
     * Setter for property
     *
     * @param string $gcpInterfaceUrl String
     */
    public function setGcpInterfaceUrl($gcpInterfaceUrl)
    {
        $this->_gcpInterfaceUrl = $gcpInterfaceUrl;
    }

    /**
     * Getter for property
     *
     * @return mixed
     */
    public function getGcpInterfaceUrl()
    {
        return $this->_gcpInterfaceUrl;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        /*$httpPrefix = 'https';
        if (Mage::app()->getStore()->isAdminUrlSecure()) {
            $httpPrefix .= 's';
        }
        $this->setGcpInterfaceUrl($httpPrefix . $this->getGcpInterfaceUrl());*/

    }

    /**
     * Get client object
     *
     * @return Zend_Gdata_HttpClient
     */
    public function getClient()
    {
        if (is_null($this->_gcpClient)) {
            $configHelper = Mage::helper('scgooglecloudprint/config');
            $login = $configHelper->getAccountLogin();
            $password = $configHelper->getAccountPassword();
            if (empty($login) || empty($password)) return false;
            $client = Zend_Gdata_ClientLogin::getHttpClient($configHelper->getAccountLogin(),
                $configHelper->getAccountPassword(),
                'cloudprint');
            $this->setGcpClient($client);
        }
        return $this->_gcpClient;
    }

    /**
     * Submit document to printer
     *
     * @param string $document Document
     * @param string $type Type
     * @param string $title Title
     * @return bool
     */
    public function submit($document, $type = 'application/pdf', $title = 'Print Job')
    {
        $configHelper = Mage::helper('scgooglecloudprint/config');
        $storeId = Mage::app()->getRequest()->getParam('store') ?
            Mage::app()->getRequest()->getParam('store') : Mage::app()->getStore()->getId();
        $client = $this->getClient();
        if (!$client) return false;
        $client->setHeaders('Authorization', 'GoogleLogin auth=' . $client->getClientLoginToken());
        $client->setUri($this->getGcpInterfaceUrl() . '/submit');
        $client->setParameterPost('printerid', $configHelper->getPrinterId($storeId));
        $client->setParameterPost('title', $title);
        $client->setParameterPost('ticket', '{"version":"1.0","print":{"vendor_ticket_item": [],"color": {"type": "STANDARD_COLOR"},"copies": {"copies": 1}}}');
        $client->setParameterPost('content', $document);
        $client->setParameterPost('contentType', $type);
        $response = $client->request(Zend_Http_Client::POST);
        $printerResponse = json_decode($response->getBody());
        if ($printerResponse->success) {
            return true;
        }
        return false;
    }

    /**
     * Return Printers list
     *
     * @return array
     */
    public function search()
    {
        $client = $this->getClient();
        if (!$client) return false;
        $client->setHeaders('Authorization', 'GoogleLogin auth=' . $client->getClientLoginToken());
        $client->setUri($this->getGcpInterfaceUrl() . '/search');
        $response = $client->request(Zend_Http_Client::POST);
        $printerResponse = json_decode($response->getBody());
        if ($printerResponse->success) {
            return $printerResponse->printers;
        }
        return false;
    }
}
