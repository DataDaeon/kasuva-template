<?php
class Perfectus_Unicase_Block_Adminhtml_System_Config_Form_Field_Btnstyles extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
		$design_cfg=Mage::helper('unicase/config')->getTpcfg('unicase_design');
       	$html .= '<br/><div id="font_'.$element->getHtmlId().'" class="" style="font-size: 13px; padding: 10px; 0">
		<style>
			.ucbtns2 {
			  background: #'.$design_cfg['basic']['btn_bg_color'].' none repeat scroll 0 0;
			  border: medium none;
			  color: #'.$design_cfg['basic']['btn_text_color'].';
			  font-size: 13px;
			  line-height: 22px;
			  transition: all 0.2s linear 0s;
			   -moz-user-select: none;
			  background-image: none;
			  border: 1px solid transparent;
			  border-radius: 4px;
			  cursor: pointer;
			  display: inline-block;
			  font-size: 14px;
			  font-weight: 400;
			  line-height: 1.42857;
			  margin-bottom: 0;
			  padding: 6px 12px;
			  text-align: center;
			  vertical-align: middle;
			  white-space: nowrap;
			  text-decoration:none;
			}
			.ucbtns2-flat {
			  background: #'.$design_cfg['basic']['btn_bg_color'].' none repeat scroll 0 0;
			  border: medium none;
			  color: #'.$design_cfg['basic']['btn_text_color'].';
			  font-size: 13px;
			  line-height: 22px;
			  transition: all 0.2s linear 0s;
			   -moz-user-select: none;
			  background-image: none;
			  border: 1px solid transparent;
			  border-radius: 0px;
			  cursor: pointer;
			  display: inline-block;
			  font-size: 14px;
			  font-weight: 400;
			  line-height: 1.42857;
			  margin-bottom: 0;
			  padding: 6px 12px;
			  text-align: center;
			  vertical-align: middle;
			  white-space: nowrap;
			  text-decoration:none;
			}
			.ucbtns1 {
				background-color: transparent;
				border: 2px solid #'.$design_cfg['basic']['btn_border_color'].';
				border-radius: 4px;
				color: #'.$design_cfg['basic']['btn_text_color'].';
				display: inline-block;
				float: left;
				font-size: 13px;
				line-height: 18px;
				padding: 6px 17px;
				text-align: center;
				text-decoration: none;
				text-transform: capitalize;
				transition: all 0.2s linear 0s;
			}
			.ucbtns1-flat {
				background-color: transparent;
				border: 2px solid #'.$design_cfg['basic']['btn_border_color'].';
				border-radius: 0px;
				color: #'.$design_cfg['basic']['btn_text_color'].';
				display: inline-block;
				float: left;
				font-size: 13px;
				line-height: 18px;
				padding: 6px 17px;
				text-align: center;
				text-decoration: none;
				text-transform: capitalize;
				transition: all 0.2s linear 0s;
			}
			.ucbtns2:hover, .ucbtns1:hover{
				background-color: #'.$design_cfg['basic']['btn_hbg_color'].';
				border-color: #'.$design_cfg['basic']['btn_hborder_color'].';
				color:#'.$design_cfg['basic']['btn_htext_color'].';
				text-decoration: none;
			}
			
		</style>
		<a href="javascript:void(0)" id="ucbtnstyle" class="ucstyle1">Button</a>
		</div>';
       	$html .= '
       			<script type="text/javascript">
       				jQuery(document).ready(function($){
       					var btnstyle = $("#'.$element->getHtmlId().'").val();
       					changebtnstyles'.$element->getHtmlId().'(btnstyle);
    					jQuery("#'.$element->getHtmlId().'").bind("change", function() {
       						value = jQuery("#'.$element->getHtmlId().'").val();
       						changebtnstyles'.$element->getHtmlId().'(value);
						});
       					function changebtnstyles'.$element->getHtmlId().'(val){ 
       						jQuery("#ucbtnstyle").attr("class",val);
    					}
    				});
       			</script>
       			';
        return $html;
    }
}
?>