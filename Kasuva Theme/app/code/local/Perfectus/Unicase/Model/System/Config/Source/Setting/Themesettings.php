<?php
class Perfectus_Unicase_Model_System_Config_Source_Setting_Themesettings
{
    public function toOptionArray()
    {
        return array(
			array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('Default')),
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Custom')),
       );
    }
}