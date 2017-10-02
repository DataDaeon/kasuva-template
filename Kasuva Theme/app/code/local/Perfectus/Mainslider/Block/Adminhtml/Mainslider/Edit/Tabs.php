<?php
class Perfectus_Mainslider_Block_Adminhtml_Mainslider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("mainslider_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("mainslider")->__("Slide Details"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("mainslider")->__("Slide Details"),
				"title" => Mage::helper("mainslider")->__("Slide Details"),
				"content" => $this->getLayout()->createBlock("mainslider/adminhtml_mainslider_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
