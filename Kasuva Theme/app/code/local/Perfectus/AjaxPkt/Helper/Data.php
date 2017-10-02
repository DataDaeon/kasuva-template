<?php
class Perfectus_AjaxPkt_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getQuickViewLink($product){
		return '<a class="lnk-quickview"  onclick="ajaxPktQuickview(this,'.$product->getId().'); return false;" href="'.$product->getProductUrl().'"><i class="fa fa-expand"></i></a><a href='.Mage::getUrl('ajaxpkt/index/options',array('product_id'=>$product->getId())).' class="ajaxpkt-qckview" id="ajaxPktQck'.$product->getId().'" style="display:none;">Ajax</a>';
	}
}