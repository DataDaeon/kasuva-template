<?php
class Perfectus_Fltproducts_Block_Promotional_Home_List extends Mage_Catalog_Block_Product_List
{
	protected $_productFltCollection;
	
    protected function _getFltProductCollection()
    {
		if (is_null($this->_productFltCollection)) {
			$storeId    = Mage::app()->getStore()->getId();
			$this->_productFltCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_productFltCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		}
		
		 $products = $this->_productFltCollection;
		 
        	$storeId    = Mage::app()->getStore()->getId();
			$websiteId = Mage::app()->getWebsite()->getId();
			$customerGroupId = 0;
			$login = Mage::getSingleton( 'customer/session' )->isLoggedIn();
			$attributes = Mage::getSingleton('catalog/config')->getProductAttributes();
			
			if($login)
				$customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId(); 
			
			$products = $this->_addProductAttributesAndPrices($products)
							->setStoreId($storeId)
            				->addStoreFilter($storeId)
							->addAttributeToSelect($attributes)
							->addMinimalPrice()
                    		->addFinalPrice()
                    		->addTaxPercents()
							->setOrder($this->get_order(), $this->get_order_dir());
			
			if($this->getData('limit') && $this->getData('limit') > 0 ){
				$products->setPageSize($this->getData('limit'));
			}else if(Mage::getStoreConfig('fltproducts/promotional/max_product')){
				$products->setPageSize(Mage::getStoreConfig('fltproducts/promotional/max_product'));
			}
			
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
       		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
			
			$todayDate = date("Y-m-d H:i:00", Mage::getModel('core/date')->timestamp(time()));
			$catalogRuleProducts = Mage::getResourceModel('catalogrule/rule_product_price_collection')
							   	->addFieldToFilter('customer_group_id',$customerGroupId)
								->addFieldToFilter('website_id',$websiteId)
                                ->addFieldToFilter('latest_start_date', array(array('lteq'=>$todayDate),array('null'=>true)))
								->addFieldToFilter('earliest_end_date', array(array('gteq'=>$todayDate),array('null'=>true)));
			
			$catalogRuleProductID = $catalogRuleProducts->getProductIds();
			
			$products->getSelect()->where('e.entity_id IN(?)',$catalogRuleProductID);
			
		$this->_productFltCollection = $products;
        return $this->_productFltCollection;
    }
    function getFltLoadedProductCollection(){
		return $this->_getFltProductCollection();
	}
}