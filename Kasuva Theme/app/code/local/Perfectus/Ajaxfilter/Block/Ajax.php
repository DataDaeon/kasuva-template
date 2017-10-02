<?php 

class Perfectus_Ajaxfilter_Block_Ajax extends Mage_Core_Block_Template{
	public function __construct(){
		
		$this->config = Mage::getStoreConfig('price_ajaxfilter');
		$this->url = Mage::getBaseUrl('media');
		
		$this->ajaxAjaxfilter = $this->config['ajax_conf']['ajaxfilter'];
		$this->ajaxLayered = $this->config['ajax_conf']['layered'];
		$this->ajaxToolbar = $this->config['ajax_conf']['toolbar'];
		$this->overlayColor = $this->config['ajax_conf']['overlay_color'];
		$this->overlayOpacity = $this->config['ajax_conf']['overlay_opacity'];
		$this->loadingText = $this->config['ajax_conf']['loading_text'];
		$this->loadingTextColor = $this->config['ajax_conf']['loading_text_color'];
		$this->loadingImage = $this->config['ajax_conf']['loading_image'];
		if($this->loadingImage == '' || $this->loadingImage == null){
			$this->loadingImage = $this->url.'perfectus/ajaxfilter/default/ajax-loader.gif';
		}else{
			$this->loadingImage = $this->url.'perfectus/ajaxfilter/'.$this->loadingImage;
		}	
	}
	
	
	public function getCallbackJs(){
		return Mage::getStoreConfig('price_ajaxfilter/ajax_conf/afterAjax');
	}
}