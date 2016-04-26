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
class Faonni_CmsPageMenu_Block_Adminhtml_Page_Edit_Tab_Navigation
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('cms_page');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

       // $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('navigation_fieldset', array('legend' => Mage::helper('cms')->__('Menus and Links')));
		
        $fieldset->addField('include_in_top_menu', 'select', array(
            'label'     => Mage::helper('cms')->__('Add to Top Menu'),
            'title'     => Mage::helper('cms')->__('Add to Top Menu'),
            'name'      => 'include_in_top_menu',
            'required'  => false,
            'options'   => Mage::getModel('faonni_cmspagemenu/adminhtml_system_config_source_position')->toArray(),
            'disabled'  => $isElementDisabled,
        ));
		
        $fieldset->addField('sort_order_top_menu', 'text', array(
            'label'     => Mage::helper('cms')->__('Sort Order in Top Menu'),
            'title'     => Mage::helper('cms')->__('Sort Order in Top Menu'),
            'name'      => 'sort_order_top_menu',
            'required'  => false,
            'disabled'  => $isElementDisabled,
        ));
		
        $fieldset->addField('include_in_top_link', 'select', array(
            'label'     => Mage::helper('cms')->__('Add to Top Link'),
            'title'     => Mage::helper('cms')->__('Add to Top Link'),
            'name'      => 'include_in_top_link',
            'required'  => false,
            'options'   => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'disabled'  => $isElementDisabled,
        ));
		
        $fieldset->addField('sort_order_top_link', 'text', array(
            'label'     => Mage::helper('cms')->__('Sort Order in Top Link'),
            'title'     => Mage::helper('cms')->__('Sort Order in Top Link'),
            'name'      => 'sort_order_top_link',
            'required'  => false,
            'disabled'  => $isElementDisabled,
        ));
		
        $fieldset->addField('include_in_footer_link', 'select', array(
            'label'     => Mage::helper('cms')->__('Add to Footer Link'),
            'title'     => Mage::helper('cms')->__('Add to Footer Link'),
            'name'      => 'include_in_footer_link',
            'required'  => false,
            'options'   => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
            'disabled'  => $isElementDisabled,
        ));
		
        $fieldset->addField('sort_order_footer_link', 'text', array(
            'label'     => Mage::helper('cms')->__('Sort Order in Footer Link'),
            'title'     => Mage::helper('cms')->__('Sort Order in Footer Link'),
            'name'      => 'sort_order_footer_link',
            'required'  => false,
            'disabled'  => $isElementDisabled,
        ));
		
        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_navigation_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('cms')->__('Menus and Links');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('cms')->__('Menus and Links');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }
}
