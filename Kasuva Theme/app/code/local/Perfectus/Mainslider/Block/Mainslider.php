<?php   
class daeon_Mainslider_Block_Mainslider extends Mage_Core_Block_Template{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
	
	public function getHome()
    {
        $collection = Mage::getModel('mainslider/mainslider')->getCollection();
    }
}
