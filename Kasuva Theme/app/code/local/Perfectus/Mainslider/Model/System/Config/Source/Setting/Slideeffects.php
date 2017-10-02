<?php
class Perfectus_Mainslider_Model_System_Config_Source_Setting_Slideeffects
{
    public function toOptionArray()
    {
		return array(
			array('value' => 'fade', 'label' => Mage::helper('unicase')->__('Fade (Default)')),
			array('value' => 'slide', 'label' => Mage::helper('unicase')->__('Slide'))
        );
    }
}