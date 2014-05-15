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
class Snowcode_GoogleCloudPrint_Block_Adminhtml_System_Configuration_Version extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Get element html
     *
     * @param Varien_Data_Form_Element_Abstract $element Field element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return (string)Mage::helper('scgooglecloudprint')->getExtensionVersion();
    }
}
