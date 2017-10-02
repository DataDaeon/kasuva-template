<?php
class Perfectus_Fltproducts_Block_Newproductcattabs_Home_List extends Mage_Catalog_Block_Product_List
{
	protected $_productFltCollection;
	
    protected function _getFltProductCollection()
    {
		if (is_null($this->_productFltCollection)) {
			$storeId    = Mage::app()->getStore()->getId();
			$this->_productFltCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_productFltCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		}
		
        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		
		$products = $this->_addProductAttributesAndPrices($this->_productFltCollection)
        ->addStoreFilter()
        ->addAttributeToFilter('news_from_date', array('date' => true, 'to' => $todayDate))
        ->addAttributeToFilter('news_to_date', array('or'=> array(
            0 => array('date' => true, 'from' => $todayDate),
            1 => array('is' => new Zend_Db_Expr('null')))
        ), 'left')
		->addAttributeToSort('news_from_date', 'desc')
        ->addAttributeToSort("entity_id","DESC")
        ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInSiteIds());
		
		if($this->getData('category_ids') && $this->getData('category_ids')!=''){
			$cat_ar = array();
			$category_ids=explode(",", $this->getData('category_ids'));
			if(!empty($category_ids)){
				foreach($category_ids as $k => $v){
					$cat_ar[] = array('finset'=> array($v));
				}
			}
			
			//$catfilters = array(27, 29, 45);  //Obviously your category ids will be different
			$conditions = array();
			foreach ($category_ids as $categoryId) {
				if (is_numeric($categoryId)) {
					$conditions[] = "{{table}}.category_id = $categoryId";
				}
			}
			
			$products->distinct(true)->joinField('category_id', 'catalog/category_product', null, 'product_id = entity_id', implode(" OR ", $conditions), 'inner');
		}
		
		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/newprodcattabs/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/newprodcattabs/max_product'));
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