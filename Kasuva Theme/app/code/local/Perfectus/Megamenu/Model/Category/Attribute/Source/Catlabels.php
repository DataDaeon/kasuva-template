<?php
class daeon_Megamenu_Model_Category_Attribute_Source_Catlabels  extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{    
    public function getAllOptions()
    {
		$labels = Mage::getStoreConfig('daeon_megamenu/category_labels');
        if (!$this->_options && !empty($labels) )
        {
			$this->_options=array();
			$this->_options[]=array('value' => '', 'label'=>Mage::helper('adminhtml')->__(''));
			foreach($labels as $k=>$v){
				$this->_options[]=array('value' => $k, 'label'=>$v);
			}
		}
        return $this->_options;
    }
}
