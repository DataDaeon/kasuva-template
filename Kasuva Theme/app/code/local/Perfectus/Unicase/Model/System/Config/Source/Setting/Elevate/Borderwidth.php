<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Elevate_Borderwidth
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label' => Mage::helper('adminhtml')->__('1px')),
            array('value' => '2', 'label' => Mage::helper('adminhtml')->__('2px')),
			array('value' => '3', 'label' => Mage::helper('adminhtml')->__('3px')),
			array('value' => '4', 'label' => Mage::helper('adminhtml')->__('4px')),
			array('value' => '5', 'label' => Mage::helper('adminhtml')->__('5px')),
			array('value' => '6', 'label' => Mage::helper('adminhtml')->__('6px')),
			array('value' => '7', 'label' => Mage::helper('adminhtml')->__('7px')),
			array('value' => '8', 'label' => Mage::helper('adminhtml')->__('8px')),
			array('value' => '9', 'label' => Mage::helper('adminhtml')->__('9px')),
			array('value' => '10', 'label' => Mage::helper('adminhtml')->__('10px')),
        );
    }
}