<?php
class Perfectus_Unicase_Block_Adminhtml_Button_Import_Demos extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $el)
    {
		$data = $el->getOriginalData();
		if (isset($data['process']))
			$process = $data['process'];
		else
			return '<div>Action was not specified</div>';
		if (isset($data['demo']))
			$demos = $data['demo'];
		else
			return '<div>Action was not specified</div>';
		
		$buttonSuffix = '';
		if (isset($data['label']))
			$buttonSuffix = ' ' . $data['label'];
		
		$url = $this->getUrl('adminhtml/unicase_demos/' . $process.'demos'). 'demos/'.$demos;
		
		if (strlen($code = Mage::getSingleton('adminhtml/config_data')->getWebsite())){
            $url .= "/website/".$code;
        }
        if (strlen($code = Mage::getSingleton('adminhtml/config_data')->getStore())){
            $url .= "/store/".$code;
        }
		
		
		$html = $this->getLayout()->createBlock('adminhtml/widget_button')
			->setType('button')
			->setClass('import-cms')
			->setLabel('Import' . $buttonSuffix)
			->setOnClick("setLocation('$url')")
			->toHtml();
			
        return $html;
    }
}