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
class Snowcode_GoogleCloudPrint_Model_System_Config_Source_Printers
{
    /**
     * Get Printers from GCP
     *
     * @return array
     */
    private function _getPrinters()
    {
        $connector = Mage::helper('scgooglecloudprint/connector');
        $printers = $connector->search();
        return (!empty($printers)) ? $printers : array();
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $printers = $this->_getPrinters();
        $resultPrinters = array();
        if (!empty($printers)) {
            foreach ($printers as $printer) {
                $resultPrinters[] = array(
                    'value' => $printer->id,
                    'label' => (!empty($printer->defaultDisplayName)) ? $printer->defaultDisplayName : $printer->name
                );
            }
        }
        return $resultPrinters;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $printers = $printers = $this->_getPrinters();
        $resultPrinters = array();
        if (!empty($printers)) {
            foreach ($printers as $printer) {
                $resultPrinters[] = array(
                    $printer->id => (!empty($printer->defaultDisplayName)) ?
                            $printer->defaultDisplayName : $printer->name
                );
            }
        }
        return $resultPrinters;
    }
}