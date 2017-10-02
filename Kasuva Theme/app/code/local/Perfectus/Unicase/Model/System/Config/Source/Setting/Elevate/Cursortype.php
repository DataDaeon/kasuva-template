<?php
class Perfectus_Unicase_Model_System_Config_Source_Setting_Elevate_Cursortype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'default', 'label' => Mage::helper('adminhtml')->__('Default')),
            array('value' => 'pointer', 'label' => Mage::helper('adminhtml')->__('Pointer')),
			array('value' => 'crosshair', 'label' => Mage::helper('adminhtml')->__('Crosshair')),
        );
    }
}