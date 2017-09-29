<?php
$installer = $this;
$installer->startSetup();

$installer->endSetup();

if (Mage::getModel('admin/block')) {
    $installer = $this;
    $installer->startSetup();
    $connection = $installer->getConnection();
	$resource = Mage::getSingleton('core/resource');
	$block_install_ar = array();
	$block_ar = array('newsletter/subscribe', 'catalog/product_new', 'twitterfeeds/tweets', 'cms/block', 'productslider/productslider');
	$rows = $connection->fetchAll('select * from '. $resource->getTableName('permission_block'));
	foreach ($rows as $k => $v) {
		if(in_array($v['block_name'], $block_ar)){
			unset($block_ar[array_search($v['block_name'], $block_ar)]);
		}
	}
	foreach($block_ar as $k => $v){
		$block_install_ar[] = array('block_name' => $v, 'is_allowed' => 1);
	}
		
	if(!empty($block_install_ar)){
		$installer->getConnection()->insertMultiple(
        $installer->getTable('admin/permission_block'), $block_install_ar);
		$installer->endSetup();
	}
}