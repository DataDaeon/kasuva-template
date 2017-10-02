<?php
class Perfectus_Unicase_Block_Adminhtml_System_Config_Form_Field_Prodbtnstyles extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
		$setting_cfg=Mage::helper('unicase/config')->getTpcfg('unicase_settings');
		$imgsrc = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'perfectus/adminoptions/'.$setting_cfg['general']['product_btn_style'].'.png';
		$html .='<div class="productBtnStyles"><img src="'.$imgsrc.'" /></div>';
       	$html .= '
       			<script type="text/javascript">
       				jQuery(document).ready(function($){
       					changebtnstyles'.$element->getHtmlId().'($("#'.$element->getHtmlId().'").val());
    					jQuery("#'.$element->getHtmlId().'").bind("change", function() {
       						changebtnstyles'.$element->getHtmlId().'(jQuery("#'.$element->getHtmlId().'").val());
						});
       					function changebtnstyles'.$element->getHtmlId().'(val){ 
							var PBtnImgPath = "'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'perfectus/adminoptions/";
							jQuery(".productBtnStyles").html("<img src="+PBtnImgPath+val+".png"+" />");
    					}
    				});
       			</script>
       			';
        return $html;
    }
}
?>