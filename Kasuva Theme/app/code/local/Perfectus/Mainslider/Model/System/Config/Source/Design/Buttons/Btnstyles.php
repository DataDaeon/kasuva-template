<?php
class daeon_kasuva_Model_System_Config_Source_Design_Buttons_btnstyles
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'ucbtns1', 'label'=>Mage::helper('kasuva')->__('Style1 (Trasparent with Borders)')),
			array('value'=>'ucbtns2', 'label'=>Mage::helper('kasuva')->__('Style2 (Dark)')),
		);
	}
}
