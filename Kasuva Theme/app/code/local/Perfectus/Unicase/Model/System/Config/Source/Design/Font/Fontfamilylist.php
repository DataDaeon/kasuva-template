<?php
class Perfectus_Unicase_Model_System_Config_Source_Design_Font_Fontfamilylist
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'default', 'label'=>Mage::helper('unicase')->__('Default')),
			array('value'=>'Roboto', 'label'=>Mage::helper('unicase')->__('Roboto')),
			array('value'=>'Fjalla One', 'label'=>Mage::helper('unicase')->__('Fjalla One')),
			array('value'=>'googlefont', 'label'=>Mage::helper('unicase')->__('Google Font..'))				
		);
	}
}
