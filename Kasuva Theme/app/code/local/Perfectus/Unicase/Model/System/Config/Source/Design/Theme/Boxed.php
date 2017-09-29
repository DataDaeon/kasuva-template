<?php

class daeon_kasuva_Model_System_Config_Source_Design_Theme_Boxed
{
    public function toOptionArray()
    {
		return array(
			array('value' => '0', 'label' => Mage::helper('kasuva')->__('Wide (Default)')),
			array('value' => '1', 'label' => Mage::helper('kasuva')->__('Boxed'))
        );
    }
}