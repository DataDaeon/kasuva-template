<?php
class daeon_Megamenu_Model_Category_Attribute_Source_Menutype  extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{    
    public function getAllOptions()
    {
        if (!$this->_options)
        {
            $this->_options = array(
			array('value' => 'default', 'label'=>Mage::helper('adminhtml')->__('Default')),
            array('value' => 'full_width', 'label'=>Mage::helper('adminhtml')->__('Full Width')),
			array('value' => 'dropdown', 'label'=>Mage::helper('adminhtml')->__('Dropdown Style')),
			array('value' => 'custom', 'label'=>Mage::helper('adminhtml')->__('Custom')),
			);
		}
        return $this->_options;
    }
}
