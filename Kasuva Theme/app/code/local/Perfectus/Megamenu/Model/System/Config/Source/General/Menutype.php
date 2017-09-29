<?php
class daeon_Megamenu_Model_System_Config_Source_General_Menutype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'full_width', 'label'=>Mage::helper('adminhtml')->__('Full Width (Default)')),
			array('value' => 'dropdown', 'label'=>Mage::helper('adminhtml')->__('Dropdown Style')),
       );
    }
}