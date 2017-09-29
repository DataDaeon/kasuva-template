<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Category_Catinfostyles
{
    public function toOptionArray()
    {
        return array(
			array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('None')),
			array('value' => 'inside', 'label'=>Mage::helper('adminhtml')->__('Default')),
			array('value' => 'boxed', 'label'=>Mage::helper('adminhtml')->__('Boxed Layout')),
			array('value' => 'full', 'label'=>Mage::helper('adminhtml')->__('Full Width')),
       );
    }
}