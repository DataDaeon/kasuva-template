<?php
class daeon_Fltproducts_Block_Specials_Home_List extends Mage_Catalog_Block_Product_List
{
    protected $_productFltCollection;
	
    protected function _getFltProductCollection()
    {
		if (is_null($this->_productFltCollection)) {
			$storeId    = Mage::app()->getStore()->getId();
			$this->_productFltCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_productFltCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		}
		
        $category_id = $this->getCategoryId();
        $todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        $tomorrow = mktime(0, 0, 0, date('m'), date('d')+1, date('y'));
        $dateTomorrow = date('m/d/y', $tomorrow);
        $products = $this->_productFltCollection;
        
        if($category_id) {
            $category = Mage::getModel('catalog/category')->load($category_id);    
            
            $products = $this->_addProductAttributesAndPrices($products)
             ->addCategoryFilter($category)
             ->addStoreFilter()
             ->addAttributeToSort('entity_id', 'desc')
             ->addAttributeToFilter('special_price', array('gt'=> -1))
             ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
             ->addAttributeToFilter('special_to_date', array('or'=> array(0 => array('date' => true, 'from' => $dateTomorrow), 1 => array('is' => new Zend_Db_Expr('null')))), 'left')
             ->setPageSize($this->getProductCount());
        }else{
            $products = $this->_addProductAttributesAndPrices($products)
             ->addStoreFilter()
             ->addAttributeToSort('entity_id', 'desc')
             ->addAttributeToFilter('special_price', array('gt'=> -1))
             ->addAttributeToFilter('special_from_date', array('date' => true, 'to' => $todayDate))
             ->addAttributeToFilter('special_to_date', array('or'=> array(0 => array('date' => true, 'from' => $dateTomorrow), 1 => array('is' => new Zend_Db_Expr('null')))), 'left')
             ->setPageSize($this->getProductCount());
        }
        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        $store = Mage::app()->getStore();
        $code  = $store->getCode();
        if(!Mage::getStoreConfig("cataloginventory/options/show_out_of_stock", $code))
            Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products); 

		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/specials/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/specials/max_product'));
		}
		
		$this->_productFltCollection = $products;
        return $this->_productFltCollection;
    }
    function getFltLoadedProductCollection(){
		return $this->_getFltProductCollection();
	}
}
?>