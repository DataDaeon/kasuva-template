<?php
class daeon_Fltproducts_Model_System_Config_Source_Setting_Numsproducts
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('1')),
			array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('2')),
			array('value' => '3', 'label'=>Mage::helper('adminhtml')->__('3')),
			array('value' => '4', 'label'=>Mage::helper('adminhtml')->__('4')),
       );
    }
}