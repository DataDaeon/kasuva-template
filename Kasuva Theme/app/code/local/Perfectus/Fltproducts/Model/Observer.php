<?php
class daeon_Fltproducts_Model_Observer{
	public function setTemplateVariables($observer){
		//$ProdCollection = Mage::getResourceModel('catalog/product_collection');
		if(!Mage::registry('FltProdCollection')){
			//$collection = Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect('*');
			//$FltProdCollection = Mage::register('FltProdCollection', $collection);
		}
	}
}
