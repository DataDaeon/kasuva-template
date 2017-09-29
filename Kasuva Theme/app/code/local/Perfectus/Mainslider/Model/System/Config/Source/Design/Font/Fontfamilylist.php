<?php
class daeon_kasuva_Model_System_Config_Source_Design_Font_Fontfamilylist
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'Roboto', 'label'=>Mage::helper('kasuva')->__('Roboto')),
			array('value'=>'googlefont', 'label'=>Mage::helper('kasuva')->__('Google Font..'))				
		);
	}
}
