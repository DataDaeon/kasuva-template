<?php
class daeon_Fltproducts_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getNewProdsCategories($_productCollection,$cat_limit){
		$newcat_ar=array();
		$j=1;
		$newcat_ar[0]=$this->__('All');
		foreach ($_productCollection as $_product){
			$cats=$_product->getCategoryIds();
			if(!empty($cats)){
				foreach($cats as $k=>$v){
					if(!array_key_exists($v, $newcat_ar)){
						$category = Mage::getModel('catalog/category')->load($v);
						$newcat_ar[$v]=$category->getName();
						if($cat_limit==$j){break 2;}
						$j++;
					}
					
				}
			}
		}
		return $newcat_ar;
	}
}