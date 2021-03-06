<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_CmsPageMenu
 * @copyright   Copyright (c) 2015 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Faonni_CmsPageMenu_Model_Adminhtml_System_Config_Source_Position
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 0, 'label' => Mage::helper('faonni_cmspagemenu')->__('No')),
            array('value' => 1, 'label' => Mage::helper('faonni_cmspagemenu')->__('Before Categories')),
			array('value' => 2, 'label' => Mage::helper('faonni_cmspagemenu')->__('After Categories')),
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
			0 => Mage::helper('faonni_cmspagemenu')->__('No'),
            1 => Mage::helper('faonni_cmspagemenu')->__('Before Categories'),
            2 => Mage::helper('faonni_cmspagemenu')->__('After Categories'),
        );
    }

}
