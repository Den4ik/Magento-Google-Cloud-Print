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
        $store = Mage::app()->getRequest()->getParam('store') ?
            Mage::app()->getRequest()->getParam('store') : Mage::app()->getStore();
        $client = $this->getClient();
        $client->setHeaders('Authorization', 'GoogleLogin auth=' . $client->getClientLoginToken());
        /*$client->setHeaders('X-CloudPrint-Proxy', 'Mimeo');*/
        $client->setUri($this->getGcpInterfaceUrl() . '/submit');
        $client->setParameterPost('printerid', $configHelper->getPrinterId($store->getId()));
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
}
