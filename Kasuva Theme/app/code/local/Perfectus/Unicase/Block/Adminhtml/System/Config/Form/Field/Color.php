<?php
class daeon_kasuva_Block_Adminhtml_System_Config_Form_Field_Color extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		$format = '';
		$color = new Varien_Data_Form_Element_Text();
		$data = array(
			'name'      => $element->getName(),
			'html_id'   => $element->getId(),
		);
		$color->setData( $data );
		$color->setValue( $element->getValue(), $format );
		$color->setForm( $element->getForm() );
		$color->addClass( 'color ' . $element->getClass() );
		
		$html=$color->getElementHtml();
		$html.='<button type="button" style="border:none;background:none;padding:0;margin:2px 0 0;float:right;" class="jscolor {valueElement:\''.$element->getId().'\',styleElement:\''.$element->getId().'\'}"><img src="'.$this->getJsUrl('daeon/kasuva/jscolor/').'color.png" /></button>';
		return $html;
    }
}
