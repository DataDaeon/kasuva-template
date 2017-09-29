<?php
class daeon_Megamenu_Model_System_Config_Source_General_Homelinkstyle
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'lnk', 'label'=>Mage::helper('adminhtml')->__('Only Link')),
			array('value' => 'icon', 'label'=>Mage::helper('adminhtml')->__('Only Icon')),
			array('value' => 'lnk-icon', 'label'=>Mage::helper('adminhtml')->__('Link with Icon')),
			array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('No')),
       );
    }
}