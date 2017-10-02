<?php
class Perfectus_Fltproducts_Block_Bestsellers_Home_List extends Mage_Catalog_Block_Product_List
{
	protected $_productFltCollection;
	
	protected function _getFltProductCollection()
	{
		$storeId = Mage::app()->getStore()->getId();
		$products = Mage::getResourceModel('reports/product_collection')
			->addAttributeToSelect('*')
			->addOrderedQty()
			->setStoreId($storeId)
			->addStoreFilter($storeId)
			->setOrder('ordered_qty', 'desc')
			->setPageSize($this->get_prod_count())
			->setOrder($this->get_order(), $this->get_order_dir())
			->setCurPage($this->get_cur_page());

		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/bestsellers/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/bestsellers/max_product'));
		}

		$productFlatData = Mage::getStoreConfig('catalog/frontend/flat_catalog_product');
		if($productFlatData == "1")
		{
			$products->getSelect()->joinLeft(
					array('flat' => 'catalog_product_flat_'.$storeId),
					"(e.entity_id = flat.entity_id ) ",
					//array(
//	                   'flat.name AS name','flat.image AS small_image','flat.price AS price','flat.minimal_price as minimal_price','flat.special_price as special_price','flat.special_from_date AS special_from_date','flat.special_to_date AS special_to_date'
//	                )
					array(
					   'flat.name AS name','flat.small_image AS small_image','flat.price AS price','flat.special_price as special_price','flat.special_from_date AS special_from_date','flat.special_to_date AS special_to_date'
					)
				);
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