<?php
class daeon_Megamenu_Model_Category_Attribute_Source_Block_Yesno  extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{    
    public function getAllOptions()
    {
        if (!$this->_options)
        {
            $this->_options = array(
			array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Yes')),
			array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('No')),
			);
		}
        return $this->_options;
    }
}
