<?php

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('catalog_product', 'featured', array(
        'type'              => 'int',
        'backend_type'      => 'int',
        'backend'           => '',
        'frontend'          => '',
        'label'             => 'Is Featured',
        'input'             => 'boolean',
        'frontend_class'    => '',
        'source'            => 'eav/entity_attribute_source_boolean',
        'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible'           => false,
        'required'          => false,
        'user_defined'      => true,
        'default'           => '',
        'searchable'        => false,
        'filterable'        => false,
        'comparable'        => false,
        'visible_on_front'  => false,
        'unique'            => false,
        'apply_to'          => '',
        'is_configurable'   => false
));

$setup->addAttributeToSet('catalog_product', 'Default', 'General', 'featured');

$installer->endSetup();

if (Mage::getModel('admin/block')) {
    $installer = $this;
    $installer->startSetup();
    $connection = $installer->getConnection();
	$resource = Mage::getSingleton('core/resource');
	$block_install_ar = array();
	$block_ar = array('fltproducts/newproductcattabs_list', 'fltproducts/newproduct_home_list', 'fltproducts/featured_home_list', 'fltproducts/bestsellers_home_list', 'fltproducts/specials_home_list', 'fltproducts/allproducts_home_list', 'fltproducts/mostviewed_home_list', 'fltproducts/promotional_home_list', 'fltproducts/lastordered_home_list');
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