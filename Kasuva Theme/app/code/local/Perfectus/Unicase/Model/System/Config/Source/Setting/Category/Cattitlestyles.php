<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Category_Cattitlestyles
{
    public function toOptionArray()
    {
        return array(
			array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('none')),
            array('value' => 'above', 'label'=>Mage::helper('adminhtml')->__('Above Image')),
			array('value' => 'inside', 'label'=>Mage::helper('adminhtml')->__('Inside Image')),
			array('value' => 'below', 'label'=>Mage::helper('adminhtml')->__('Below Image')),
       );
    }
}