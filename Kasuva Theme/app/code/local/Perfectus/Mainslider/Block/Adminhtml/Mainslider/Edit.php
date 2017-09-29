<?php
class daeon_Mainslider_Block_Adminhtml_Mainslider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{
			parent::__construct();
					 
			$this->_objectId = 'id';
			$this->_blockGroup = 'mainslider';
			$this->_controller = 'adminhtml_mainslider';
			
			$this->_updateButton('save', 'label', Mage::helper('mainslider')->__('Save Slide'));
			$this->_updateButton('delete', 'label', Mage::helper('mainslider')->__('Delete Slide'));
			
			$this->_addButton('saveandcontinue', array(
				'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
				'onclick'   => 'saveAndContinueEdit()',
				'class'     => 'save',
			), -100);

			$this->_formScripts[] = "
				function toggleEditor(){
					if (tinyMCE.getInstanceById('mainslider_content') == null) {
						tinyMCE.execCommand('mceAddControl', false, 'mainslider_content');
					} else {
						tinyMCE.execCommand('mceRemoveControl', false, 'mainslider_content');
					}
				}
				function saveAndContinueEdit(){
					editForm.submit($('edit_form').action+'back/edit/');
				}
			";
		}

		public function getHeaderText()
		{
				if( Mage::registry("mainslider_data") && Mage::registry("mainslider_data")->getId() ){
				    return Mage::helper("mainslider")->__("Edit Slide '%s'", $this->htmlEscape(Mage::registry("mainslider_data")->getPslideName()));
				} 
				else{

				     return Mage::helper("mainslider")->__("Add Slide");

				}
		}
}
