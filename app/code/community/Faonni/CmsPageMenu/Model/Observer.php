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
class Faonni_CmsPageMenu_Model_Observer
{
    /**
     * CMS page collection
     *
     * @var array
     */
    protected $_collections;
	
    /**
     * Get cms page collection
     *
     * @param string $field 
     * @return array
     */
    public function getCollection($field)
    {
		$fields = array('top_menu', 'top_link', 'footer_link');
		if (!isset($this->_collections[$field])) {
			$identifier = Mage::getSingleton('cms/page')->getIdentifier();
			$collection = Mage::getModel('cms/page')->getCollection();
			$collection
				->addStoreFilter(Mage::app()->getStore()->getId())
				->addFieldToFilter(
					array('main_table.include_in_top_menu', 'main_table.include_in_top_link', 'main_table.include_in_footer_link'), 
					array(array('in' => array(1, 2)), array('eq' => 1), array('eq' => 1))
				);
			foreach ($collection as $page) {
				foreach ($fields as $field) {
					if (0 < $page->getData('include_in_' . $field)) {
						$this->_collections[$field][] = array(
							'name'       => $page->getTitle(),
							'id'         => 'cms-page-' . $page->getPageId(),
							'url'        => Mage::getUrl(null, array('_direct' => $page->getIdentifier())),
							'is_active'  => ($page->getIdentifier() == $identifier) ? true : false,
							'sort_order' => $page->getData('sort_order_' . $field),
							'position'   => $page->getData('include_in_' . $field)
						);					
					}
				}
			}
			//add sort method !!!
		}
        return $this->_collections[$field];
    }	
	
    /**
     * Set current entity key
     *
     * @param Varien_Event_Observer $observer
     * @return Faonni_CmsPageMenu_Model_Observer	 
     */
    public function render(Varien_Event_Observer $observer)
    {
		if (empty(Mage::registry('current_entity_key'))) {
			$page = $observer->getEvent()->getPage();
			Mage::register('current_entity_key', 'cms_page_' . $page->getPageId());
		}
		return $this;
	}
	
    /**
     * add Links to Top menu
     *
     * @param Varien_Event_Observer $observer
     * @return Faonni_CmsPageMenu_Model_Observer	 
     */
    public function addToTopMenu(Varien_Event_Observer $observer)
    {
		$collection = $this->getCollection('top_menu');
		if (empty($collection)) return $this;
		
		$items = array();
		$after = array();
		$menu = $observer->getMenu();			

		foreach ($collection as $data) {
			$node = new Varien_Data_Tree_Node($data, 'id', $menu->getTree(), $menu);
			if ($data['position'] == 1) {
				$items[] = $node;
			} else {
				$after[] = $node;
			}
		}
		//loop through existing menu items, add them to the array and remove them from the    menu
		foreach ($menu->getChildren() as $child){
			$items[] = $child;
			$menu->removeChild($child);
		}
		//recreate the menu in the order I need
		foreach (array_merge($items, $after) as $child){
			$menu->addChild($child);
		}
		return $this;
	}
	
    /**
     * add to links block
     *
     * @param Varien_Event_Observer $observer
     * @return Faonni_CmsPageMenu_Model_Observer	 
     */
    public function addToLinks(Varien_Event_Observer $observer)
    {
		$block = $observer->getEvent()->getBlock();
		if($block instanceof Mage_Page_Block_Template_Links){
			
			$collection = array();

			if ('top.links' == $block->getNameInLayout()) {
				$collection = $this->getCollection('top_link');
			} elseif ('footer_links' == $block->getNameInLayout()) {
				$collection = $this->getCollection('footer_link');
			}
			
			foreach($collection as $link) {
				$block->addLink(
					$link['name'], $link['url'], $link['name'], false, array(), $link['sort_order']
				);			
			}
		}
		return $this;
	}
	
    /**
     * Save cms page
     *
     * @param Varien_Event_Observer $observer
     * @return Faonni_CmsPageMenu_Model_Observer	 
     */	
	public function save(Varien_Event_Observer $observer)
	{
		$page = $observer->getEvent()->getPage();
		$data = $observer->getEvent()->getRequest()->getPost();
		
		$columns = array(
			'include_in_menu', 
			'sort_order_top_menu', 
			'include_in_top_link', 
			'sort_order_top_link', 
			'include_in_footer_link', 
			'sort_order_footer_link'
		);
		
		foreach ($columns as $column) {
			$value = empty($data[$column]) ? 0 : (int)$data[$column];
			$page->setData($column, $value);
		}		

		return $this;
	}	
}