<?php
class daeon_kasuva_Model_System_Config_Source_Design_Buttons_Btnstyles
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'ucbtns1', 'label'=>Mage::helper('kasuva')->__('Style1 (Trasparent with Radius Border)(default)')),
			array('value'=>'ucbtns1-flat', 'label'=>Mage::helper('kasuva')->__('Style1 (Trasparent with Flat Border)')),
			array('value'=>'ucbtns2', 'label'=>Mage::helper('kasuva')->__('Style2 (Background with Radius Border)')),
			array('value'=>'ucbtns2-flat', 'label'=>Mage::helper('kasuva')->__('Style2 (Background with Flat Border)')),
		);
	}
}
