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
class Snowcode_GoogleCloudPrint_Model_Sales_Order_Pdf_Shipment extends Mage_Sales_Model_Order_Pdf_Shipment
{
    /**
     * Set font as regular
     *
     * @param Zend_Pdf_Page $object Page
     * @param int $size Size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontRegular($object, $size = 7)
    {
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
        $object->setFont($font, $size);
        return $font;
    }

    /**
     * Set font as bold
     *
     * @param Zend_Pdf_Page $object Page
     * @param int $size Size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontBold($object, $size = 7)
    {
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
        $object->setFont($font, $size);
        return $font;
    }

    /**
     * Set font as italic
     *
     * @param Zend_Pdf_Page $object Page
     * @param int $size Size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontItalic($object, $size = 7)
    {
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_ITALIC);
        $object->setFont($font, $size);
        return $font;
    }
}