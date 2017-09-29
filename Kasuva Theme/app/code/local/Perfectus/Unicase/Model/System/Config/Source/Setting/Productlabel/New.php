<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Productlabel_New
{
    public function toOptionArray()
    {
        return array(
            array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => '0', 'label'=>Mage::helper('adminhtml')->__('No')),
        );
    }
}