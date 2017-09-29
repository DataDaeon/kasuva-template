<?php
class daeon_kasuva_Model_System_Config_Source_Design_Buttons_Prodbtnstyles
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'ucbs1-l', 'label'=>Mage::helper('kasuva')->__('Style1 (Large Size)')),
			array('value'=>'ucbs1-m', 'label'=>Mage::helper('kasuva')->__('Style1 (Medium Size)(default)')),
			array('value'=>'ucbs1-s', 'label'=>Mage::helper('kasuva')->__('Style1 (Small Size)')),
			array('value'=>'ucbs2-l', 'label'=>Mage::helper('kasuva')->__('Style2 (Large Size)')),
			array('value'=>'ucbs2-m', 'label'=>Mage::helper('kasuva')->__('Style2 (Medium Size)')),
			array('value'=>'ucbs2-s', 'label'=>Mage::helper('kasuva')->__('Style2 (Small Size)')),
		);
	}
}
