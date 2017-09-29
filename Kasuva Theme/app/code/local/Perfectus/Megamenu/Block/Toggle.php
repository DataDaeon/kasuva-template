<?php
class daeon_Megamenu_Block_Toggle extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        if (!Mage::getStoreConfig('daeon_megamenu/general/enabled')) return;
        $layout = $this->getLayout();
        $topnav = $layout->getBlock('catalog.topnav');
        $head   = $layout->getBlock('head');
        if(is_object($topnav) && is_object($head)) {
			$topnav->setTemplate('daeon/megamenu/top.phtml');
			$head->addItem('skin_js', 'megamenu/js/megamenu.js');
			$head->addItem('skin_css', 'megamenu/css/megamenu.css');
        }
    }
}
