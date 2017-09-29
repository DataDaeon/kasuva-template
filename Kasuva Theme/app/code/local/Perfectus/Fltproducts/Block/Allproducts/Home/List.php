<?php
class daeon_Fltproducts_Block_Allproducts_Home_List extends Mage_Catalog_Block_Product_List
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
			->addAttributeToSelect('*')
			->setStoreId($storeId)
			->addStoreFilter($storeId);
			
		if($this->getData('product_ids') && $this->getData('product_ids')!=''){
			$prod_ar = array();
			$product_ids=explode(",", $this->getData('product_ids'));
			if(!empty($product_ids)){
				$products->addFieldToFilter('entity_id', array('in'=> $product_ids));
			}
		}
		
		if($this->getData('category_id') && $this->getData('category_id')!=''){
			$cat_ar = array();
			$category_id=explode(",", $this->getData('category_id'));
			if(!empty($category_id)){
				foreach($category_id as $k => $v){
					$cat_ar[] = array('finset'=> array($v));
				}
			}
			
			//$catfilters = array(27, 29, 45);  //Obviously your category ids will be different
			$conditions = array();
			foreach ($category_id as $categoryId) {
				if (is_numeric($categoryId)) {
					$conditions[] = "{{table}}.category_id = $categoryId";
				}
			}
			
			$products->distinct(true)->joinField('category_id', 'catalog/category_product', null, 'product_id = entity_id', implode(" OR ", $conditions), 'inner');
		}
		
		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/allproducts/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/allproducts/max_product'));
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