<?php
class daeon_kasuva_Model_System_Config_Source_Design_Font_Fontweight
{
	public function toOptionArray()
	{	
		return array(
			array('value'=>'default', 'label'=>Mage::helper('kasuva')->__('Default')),
			array('value'=>'100', 'label'=>Mage::helper('kasuva')->__('100')),
			array('value'=>'200', 'label'=>Mage::helper('kasuva')->__('200')),
			array('value'=>'300', 'label'=>Mage::helper('kasuva')->__('300')),
			array('value'=>'400', 'label'=>Mage::helper('kasuva')->__('400')),
			array('value'=>'500', 'label'=>Mage::helper('kasuva')->__('500')),
			array('value'=>'600', 'label'=>Mage::helper('kasuva')->__('600')),
			array('value'=>'700', 'label'=>Mage::helper('kasuva')->__('700')),
			array('value'=>'800', 'label'=>Mage::helper('kasuva')->__('800')),
			array('value'=>'900', 'label'=>Mage::helper('kasuva')->__('900')),
		);
	}
}
