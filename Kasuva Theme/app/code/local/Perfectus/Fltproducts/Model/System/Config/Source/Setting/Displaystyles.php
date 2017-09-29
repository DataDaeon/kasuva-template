<?php
class daeon_Fltproducts_Model_System_Config_Source_Setting_Displaystyles
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'slider', 'label'=>Mage::helper('adminhtml')->__('Slider')),
			array('value' => 'micro', 'label'=>Mage::helper('adminhtml')->__('Micro Slider')),
       );
    }
}