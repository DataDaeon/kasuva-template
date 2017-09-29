<?php

class daeon_Fltproducts_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/fltproducts?id=15 
    	 *  or
    	 * http://site.com/fltproducts/id/15 	
    	 */
    	/* 
		$fltproducts_id = $this->getRequest()->getParam('id');

  		if($fltproducts_id != null && $fltproducts_id != '')	{
			$fltproducts = Mage::getModel('fltproducts/fltproducts')->load($fltproducts_id)->getData();
		} else {
			$fltproducts = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($fltproducts == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$fltproductsTable = $resource->getTableName('fltproducts');
			
			$select = $read->select()
			   ->from($fltproductsTable,array('fltproducts_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$fltproducts = $read->fetchRow($select);
		}
		Mage::register('fltproducts', $fltproducts);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
	public function bestsellersAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config1/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}	
		else
		{
		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('Besesellers');    
		$this->renderLayout();
		}
    }
	public function featuredAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config2/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('Featured Products');    
		$this->renderLayout();
    }
	public function mostviewedAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config3/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('Mostviewed products');    
		$this->renderLayout();
    }
	public function newproductAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config4/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('New products');    
		$this->renderLayout();
    }
	
	public function allproductAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config5/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('All products');    
		$this->renderLayout();
    }
	
	public function promotionalAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config6/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('Promotional Products');    
		$this->renderLayout();
    }

	public function recentlyorderedAction()
    {

		$url = Mage::getUrl('no-route'); 

		$enable = Mage::getStoreConfig('fltproducts/config7/active');
		if($enable != 1) 
		{
			Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}

		$this->loadLayout(); 
		$this->getLayout()->getBlock('head')->setTitle('Recently Ordered Products');    
		$this->renderLayout();
    }
	
}