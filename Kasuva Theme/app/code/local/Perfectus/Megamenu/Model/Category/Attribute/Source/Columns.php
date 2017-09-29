<?php
class daeon_Megamenu_Model_Category_Attribute_Source_columns  extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{    
    public function getAllOptions()
    {
        if (!$this->_options)
        {
            $this->_options = array(
			array('value' => '1', 'label'=>Mage::helper('adminhtml')->__('1')),
            array('value' => '2', 'label'=>Mage::helper('adminhtml')->__('2')),
			array('value' => '3', 'label'=>Mage::helper('adminhtml')->__('3')),
			array('value' => '4', 'label'=>Mage::helper('adminhtml')->__('4')),
			array('value' => '5', 'label'=>Mage::helper('adminhtml')->__('5')),
			array('value' => '6', 'label'=>Mage::helper('adminhtml')->__('6')),
			array('value' => '7', 'label'=>Mage::helper('adminhtml')->__('7')),
			array('value' => '8', 'label'=>Mage::helper('adminhtml')->__('8')),
			array('value' => '9', 'label'=>Mage::helper('adminhtml')->__('9')),
			array('value' => '10', 'label'=>Mage::helper('adminhtml')->__('10')),
			array('value' => '11', 'label'=>Mage::helper('adminhtml')->__('11')),
			array('value' => '12', 'label'=>Mage::helper('adminhtml')->__('12')),
			);
		}
        return $this->_options;
    }
}
