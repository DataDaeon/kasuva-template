<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Productinfo_Tabstyles
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'verticle', 'label'=>Mage::helper('adminhtml')->__('Verticle (Default)')),
			array('value' => 'horizontal', 'label'=>Mage::helper('adminhtml')->__('Horizontal')),
        );
    }
}