<?php
class Perfectus_Unicase_Model_System_Config_Source_Setting_Newsletter_Showon {
    public function toOptionArray() {
        $options = array(
            array('value' => '1', 'label' => Mage::helper('unicase')->__('Home Page Only')),
            array('value' => '2', 'label' => Mage::helper('unicase')->__('All Pages')),
        );
        return $options;
    }

}