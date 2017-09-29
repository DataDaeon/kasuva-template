<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Productinfo_Productlayouts
{
    public function toOptionArray()
    {
        return array(
            array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('Default')),
			array('value' => '1column', 'label'=>Mage::helper('adminhtml')->__('1 Column')),
			array('value' => '2columns-left', 'label'=>Mage::helper('adminhtml')->__('2 Columns Left')),
			array('value' => '2columns-right', 'label'=>Mage::helper('adminhtml')->__('2 Columns Right')),
			array('value' => '3columns', 'label'=>Mage::helper('adminhtml')->__('3 Columns')),
        );
    }
}