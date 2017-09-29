<?php
class daeon_Mainslider_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_CONFIG_URL_PREFIX = 'daeon_mainslider/mainslidergroup/page_url';
	const DEFAULT_ROOT = 'mainslider';
	const XML_ROOT = 'daeon_mainslider/mainslidergroup/page_url';
	public function toUrlKey($string)
    {
        $urlKey = preg_replace(array('/[^a-z0-9-_]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $string);
        if (empty($urlKey)){
            $urlKey = time();
        }
        return strtolower($urlKey);
    }
	
	public function getMainsliderUrl()
    {
        return Mage::getModel('core/url')->getUrl(Mage::getStoreConfig(self::XML_CONFIG_URL_PREFIX));
    }
	
	public function getUrlPrefix()
    {
        return Mage::getStoreConfig(self::XML_CONFIG_URL_PREFIX);
    }
    public function conf($code, $store = null)
    {
        return Mage::getStoreConfig($code, $store);
    }
	public function getRoute($store = null)
    {
        $route = trim($this->conf(self::XML_ROOT));
        if (!$route) {
            $route = self::DEFAULT_ROOT;
        }
        return $route;
    }
    public function getRouteUrl($store = null)
    {
        return Mage::getUrl($this->getRoute($store), array('_store' => $store));

    }
    public function getStoreIdByCode($storeCode)
    {
        foreach (Mage::app()->getStore()->getCollection() as $store) {
            if ($storeCode == $store->getCode()) {
                return $store->getId();
            }
        }
        return false;
    }
    public function ifStoreChangedRedirect()
    {
        $path = Mage::app()->getRequest()->getPathInfo();

        $helper = Mage::helper('mainslider');
        $currentRoute = $helper->getRoute();

        $fromStore = Mage::app()->getRequest()->getParam('___from_store');
        if ($fromStore) {

            $fromStoreId = $helper->getStoreIdByCode($fromStore);
            $fromRoute = $helper->getRoute($fromStoreId);

            $url = preg_replace("#$fromRoute#si", $currentRoute, $path, 1);
            $url = Mage::getBaseUrl() . ltrim($url, '/');

            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($url)
                ->sendResponse();
            exit;
        }
    }
	public function getSliderTpcfg($name = null)
	{
		if($name){
			return Mage::getStoreConfig($name, Mage::app()->getStore()->getId());
		}
		return null;
	}
	public function getSliderOptions()
	{
		$cfgoptions=Mage::helper('mainslider')->getSliderTpcfg('daeon_mainslider/options');
		$mainslider=array();
		$sldspeed=($cfgoptions['slider_slidetransspeed'])? filter_var($cfgoptions['slider_slidetransspeed'], FILTER_SANITIZE_NUMBER_INT) : 200;
		$sw=($cfgoptions['slider_width'])? filter_var($cfgoptions['slider_width'], FILTER_SANITIZE_NUMBER_INT) : 1140;
		$sh=($cfgoptions['slider_height'])? filter_var($cfgoptions['slider_height'], FILTER_SANITIZE_NUMBER_INT) : 400;
		$mainslider['autoPlay']=(($cfgoptions['slider_autoplay'])? true : false);
		$mainslider['slideSpeed']=$sldspeed;
		$mainslider['pagination']=(($cfgoptions['slider_pager'])? true : false);
		$mainslider['stopOnHover']=(($cfgoptions['slider_onhoverpause'])? true : false);
		$mainslider['navigation']=(($cfgoptions['slider_controls'])? true : false);
		//$mainslider['infinite']=(($cfgoptions['slider_infinite'])? true : false);
		if($cfgoptions['full_width']){
			//$mainslider['fullWidth']=true;
		}else{
			$mainslider['slideWidth']=$sw;
		}
		if($cfgoptions['auto_height']){
			$mainslider['autoHeight']=(($cfgoptions['auto_height'])? true : false);
		}else{
			$mainslider['slideHeight']=$sh;
		}
		$mainslider['transitionStyle']=$cfgoptions['slider_effecttype'];
		//$mainslider['cssEase']= 'ease';
		//$mainslider['accessibility']= true;
		$mainslider['singleItem']= true;
		$mainslider['addClassActive']= true;
		$mainslider['item']= 1;
		
		/*$chfhtml.= "'controls': ".(($cfgoptions['slider_controls'])? 'true' : 'false').",";
		
		$chfhtml.= "'fullWidth' : ".(($cfgoptions['full_width'])? 'true' : 'false').",";
		$chfhtml.= "'controls': ".(($cfgoptions['slider_controls'])? 'true' : 'false').",";
		$chfhtml.= "'pager' : ".(($cfgoptions['slider_pager'])? 'true' : 'false').",";
		$chfhtml.= "'increase' : ".(($cfgoptions['auto_height'])? 'true' : 'false').",";
		$chfhtml.= "'pauseOnHover' : ".(($cfgoptions['slider_onhoverpause'])? 'true' : 'false').",";
		$sldspeed=($cfgoptions['slider_slidetransspeed'])? filter_var($cfgoptions['slider_slidetransspeed'], FILTER_SANITIZE_NUMBER_INT) : '1000';
		$chfhtml.= "'slideTransitionSpeed' : ".$sldspeed.",";
		$sw=($cfgoptions['slider_width']==1 && $cfgoptions['auto_height']==0)? filter_var($cfgoptions['slider_width'], FILTER_SANITIZE_NUMBER_INT) : '1170';
		$sh=($cfgoptions['slider_height']==1 && $cfgoptions['auto_height']==0)? filter_var($cfgoptions['slider_height'], FILTER_SANITIZE_NUMBER_INT) : '400';
		if($cfgoptions['full_width']==0 || ($cfgoptions['full_width']==1 && $cfgoptions['auto_height']==1)){
			$chfhtml.= "'dimensions' : '".$sw.",".$sh."',";
		}
		$chfhtml.= "'autoplay' : ".(($cfgoptions['slider_autoplay'])? 'true' : 'false').",";
		$chfhtml.= "'responsive':true,";
		//$chfhtml.= "'timeout' : 100,"; */
		return $mainslider;
	}
}
	 
