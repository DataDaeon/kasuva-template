<?php
class Perfectus_Megamenu_Block_Sidebarnav extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        if (!Mage::getStoreConfig('perfectus_megamenu/general/sidebar_enabled')) return;
        $layout = $this->getLayout();
		$sidebarnav = $layout->getBlock('sidebarnav');
		if (!is_object($sidebarnav)) {
			$sidebarnav = $layout->createBlock('core/template', 'sidebarnav')->setTemplate('perfectus/megamenu/sidebar.phtml');
		}
        $head   = $layout->getBlock('head');
        if (is_object($sidebarnav) && is_object($head)) {
            $head->addItem('skin_js', 'megamenu/js/megamenu.js');
            $head->addItem('skin_css', 'megamenu/css/megamenu.css');
        }
    }
}
