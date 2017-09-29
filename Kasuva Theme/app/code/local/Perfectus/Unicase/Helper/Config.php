<?php
class daeon_kasuva_Helper_Config extends Mage_Core_Helper_Abstract
{
	public function getTpcfg($name = null)
	{
		if($name){
			return Mage::getStoreConfig($name, Mage::app()->getStore()->getId());
		}
		return null;
	}
	public function getFonts($name = null)
	{
		$fonts=$this->getTpcfg('font');
		if($fonts['font_family']=='googlefont'){
			return $fonts['gogle_fontfamily'];
		}
		return $fonts['font_family'];
	}
}