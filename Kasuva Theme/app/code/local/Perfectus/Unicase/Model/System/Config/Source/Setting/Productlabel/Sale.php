<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Productlabel_Sale
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Sale')),
            array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('%')),
            array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }
}