<?php
class daeon_Fltproducts_Block_Lastordered_Home_List extends daeon_Fltproducts_Block_Lastordered_List
{
	protected $_productFltCollection;
	
    protected function _getFltProductCollection()
    {
		if (is_null($this->_productFltCollection)) {
			$storeId    = Mage::app()->getStore()->getId();
			$this->_productFltCollection = Mage::getResourceModel('catalog/product_collection');
			$this->_productFltCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
		}
		$storeId = Mage::app()->getStore()->getId();
		$itemsCollection = Mage::getResourceModel('sales/order_item_collection') 
						->join('order', 'order_id=entity_id') 
						->addFieldToFilter('main_table.store_id', array('eq'=>$storeId))
						->setOrder('main_table.created_at','desc') 
						->setPageSize(12);
		
		$itemsCollection->getSelect()->group(`main_table`.'product_id');

		$prod = array();        
		if(sizeof($itemsCollection)>0)
		{
			foreach ($itemsCollection as $item) {
				//$product = Mage::getModel('catalog/product')->load($item->getProductId());
				$prod[] = $item->getProductId(); 
			}    
		}

		$products = $this->_addProductAttributesAndPrices($this->_productFltCollection)
		->addAttributeToSelect('*')
		->addAttributeToSelect(array('name', 'price', 'small_image'))
		->setStoreId($storeId)
		->addStoreFilter($storeId);
		

		$products->getSelect()->where('e.entity_id IN(?)',$prod );
		
		if($this->getData('limit') && $this->getData('limit') > 0 ){
			$products->setPageSize($this->getData('limit'));
		}else if(Mage::getStoreConfig('fltproducts/lastordered/max_product')){
			$products->setPageSize(Mage::getStoreConfig('fltproducts/lastordered/max_product'));
		}

		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
	        
		$this->_productFltCollection = $products;

		return $this->_productFltCollection;
	}
	
	function getFltLoadedProductCollection(){
		return $this->_getFltProductCollection();
	}
}