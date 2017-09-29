<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Elevate_Zoomtype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'window', 'label' => Mage::helper('adminhtml')->__('Window (Default)')),
            array('value' => 'inner', 'label' => Mage::helper('adminhtml')->__('Inner')),
			array('value' => 'lens', 'label' => Mage::helper('adminhtml')->__('Lens')),
        );
    }
}