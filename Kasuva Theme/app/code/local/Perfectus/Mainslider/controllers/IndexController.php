<?php
class Perfectus_Mainslider_IndexController extends Mage_Core_Controller_Front_Action{
	 public function indexAction()
    {
    	if(!Mage::getStoreConfig('tab1/general/enable')){
            $this->norouteAction();
            return $this;
        }


    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/bannerslider?id=15 
    	 *  or
    	 * http://site.com/bannerslider/id/15 	
    	 */
    	
		$bannerslider_id = $this->getRequest()->getParam('id');

  		if($bannerslider_id != null && $bannerslider_id != '')	{
			$bannerslider = Mage::getModel('bannerslider/bannerslider')->load($bannerslider_id)->getData();
		} else {
			$bannerslider = null;
		}	
		
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	
    	if($bannerslider == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$bannersliderTable = $resource->getTableName('bannerslider');
			
			$select = $read->select()
			   ->from($bannersliderTable,array('bannerslider_id','title','filename','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$bannerslider = $read->fetchRow($select);
		}
		Mage::register('bannerslider', $bannerslider);
		

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    public function IndexAction() {
      $_module_enabaled = Mage::getStoreConfig('perfectus_mainslider/settings/mainslider_enable');
      
      if($_module_enabaled==1){
		
		$mainslider = Mage::getModel('mainslider/mainslider');
		 
		Mage::register('bannerslider', $bannerslider);
		
		$this->loadLayout();   
		$this->getLayout()->getBlock("head")->setTitle($this->__("Mainslider Category"));
		$block = $this->getLayout()->createBlock('mainslider/mainslider')->setTemplate('perfectus/mainslider/slider.phtml'))->renderLayout();
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout(); 
      }else{
			$this->getResponse()->setHeader('HTTP/1.1','404 Not Found');
			$this->getResponse()->setHeader('Status','404 File not found');
			$this->_forward('defaultNoRoute');
		}
    }
}
