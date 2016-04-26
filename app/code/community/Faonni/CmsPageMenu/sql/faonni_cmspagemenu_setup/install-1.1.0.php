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
 
$installer = $this;
$installer->startSetup();
$connection = $installer->getConnection();

$columns = array(
	'include_in_top_menu', 
	'sort_order_top_menu', 
	'include_in_top_link', 
	'sort_order_top_link', 
	'include_in_footer_link', 
	'sort_order_footer_link'
);

foreach ($columns as $column) {
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('cms/page'), $column)){
		$installer->getConnection()->addColumn($installer->getTable('cms/page'), $column, 'SMALLINT(6) NOT NULL DEFAULT 0');
	} 
}

$installer->endSetup();