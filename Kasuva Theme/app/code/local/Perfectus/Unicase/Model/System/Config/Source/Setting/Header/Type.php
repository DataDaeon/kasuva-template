<?php
class Perfectus_Unicase_Model_System_Config_Source_Setting_Header_Type
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label' => Mage::helper('adminhtml')->__('Style 1 (Default)')),
            array('value' => '1', 'label' => Mage::helper('adminhtml')->__('Style 2')),
			array('value' => '2', 'label' => Mage::helper('adminhtml')->__('Style 3')),
        );
    }
}