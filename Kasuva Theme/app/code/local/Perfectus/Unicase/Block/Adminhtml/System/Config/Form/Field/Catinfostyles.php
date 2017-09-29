<?php
class daeon_kasuva_Block_Adminhtml_System_Config_Form_Field_Catinfostyles extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
       	$html .= '
       			<script type="text/javascript">
       				jQuery(document).ready(function($){
       					var catval = $("#'.$element->getHtmlId().'").val();
						catstylevariation'.$element->getHtmlId().'(catval);
    					jQuery("#'.$element->getHtmlId().'").bind("change", function() {
       						value = jQuery("#'.$element->getHtmlId().'").val();
       						catstylevariation'.$element->getHtmlId().'(value);
						});
       					function catstylevariation'.$element->getHtmlId().'(val){ 
       						if(val=="full" || val=="0" ){
								jQuery("#row_kasuva_settings_category_categoryinfo_title").hide();
								jQuery("#row_kasuva_settings_category_categoryinfo_desc").hide();
							}else{
								jQuery("#row_kasuva_settings_category_categoryinfo_title").show();
								jQuery("#row_kasuva_settings_category_categoryinfo_desc").show();
							}
    					}
    				});
       			</script>
       			';
        return $html;
    }
}
?>