<?php
class Perfectus_Unicase_Model_System_Config_Source_Setting_Elevate_Lenstype
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'square', 'label' => Mage::helper('adminhtml')->__('Square (Default)')),
            array('value' => 'round', 'label' => Mage::helper('adminhtml')->__('Round')),
        );
    }
}