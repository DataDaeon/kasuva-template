<?php
class daeon_kasuva_Model_System_Config_Source_Setting_Newsletter_Showon {
    public function toOptionArray() {
        $options = array(
            array('value' => '1', 'label' => Mage::helper('kasuva')->__('Home Page Only')),
            array('value' => '2', 'label' => Mage::helper('kasuva')->__('All Pages')),
        );
        return $options;
    }

}