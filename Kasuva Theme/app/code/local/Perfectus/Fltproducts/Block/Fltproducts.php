<?php
class daeon_Fltproducts_Block_Fltproducts extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFltproducts()     
     { 
        if (!$this->hasData('fltproducts')) {
            $this->setData('fltproducts', Mage::registry('fltproducts'));
        }
        return $this->getData('fltproducts');
        
    }
}