<?php 
class Perfectus_Fltproducts_Block_Newproductcattabs_List extends Mage_Catalog_Block_Product_List
{
    protected function _getProductCollection()
    {
		
		parent::__construct();

        $products = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSort("entity_id","DESC")
			->addAttributeToSelect(array('name', 'price', 'small_image'))
   			->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInSiteIds())
    		->setPageSize($this->get_prod_count())
            ->addAttributeToSort($this->get_order(), $this->get_order_dir())
            ->setCurPage($this->get_cur_page());

        Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($products);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($products);
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($products);

        $this->_productCollection = $products;

        return $this->_productCollection;
	}
	
	public function getToolbarHtml()
	{
	
	}
}