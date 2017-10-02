<?php
class Perfectus_Mainslider_Block_Adminhtml_Mainslider_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{
 
    public function render(Varien_Object $row)
    {        
        $html = '<img ';
        $html .= 'id="' . $this->getColumn()->getId() . '" width="auto" height="auto" style="width:auto;max-width:100%;height:auto;"';
			if(file_exists(Mage::getBaseDir('media').'/perfectus/mainslider/'.$row->getPslideImage())){
				$html .= 'src="' .Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'perfectus/mainslider/'.$row->getPslideImage(). '"';
			}		
			else {
				$html .= 'src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'perfectus/mainslider/ImageNotAvailable.jpg"';    
			}
			$html .= 'class="grid-image" '.$this->getColumn()->getInlinecss().'/>';
			return $html;
		}
}
?>
