<?php
class Perfectus_Fltproducts_Block_Featured_Home_List extends Mage_Catalog_Block_Product_List
{
	protected $_productFltCollection;
	
    protected function _getFltProductCollection()
    {
		if (is_null($this->_productFltCollection)) {
			$storeId    = Mage::app()->getStore()->getId();
			$this->_productFltCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_productFltCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		}
		$products = $this->_addProductAttributesAndPrices($this->_productFltCollection)
			->addAttributeToFilter(array(array('attribute' => 'featured', 'eq' => '1')))
			->addAttributeToSelect('*')
			->setStoreId($storeId)
			->addStoreFilter($storeId);
		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/featured/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/featured/max_product'));
		}

		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
		Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products);

		$this->_productFltCollection = $products;

		return $this->_productFltCollection;
	}
		
	function getFltLoadedProductCollection(){
		return $this->_getFltProductCollection();
	}
}