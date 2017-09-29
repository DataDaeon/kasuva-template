<?php 
    class daeon_kasuva_Adminhtml_kasuva_ImportController extends Mage_Adminhtml_Controller_Action{ 
        public function indexAction() {
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/kasuva_settings/"));
        }
        public function blocksAction() {
            $ow = Mage::helper('kasuva/config')->getTpcfg('kasuva_settings/theme_install/overwrite_pages');
            Mage::getSingleton('kasuva/import_cms')->importCms('cms/block', 'blocks', $ow);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/kasuva_settings/"));
        }
        public function pagesAction() {
            $ow = Mage::helper('kasuva/config')->getTpcfg('kasuva_settings/theme_install/overwrite_pages');
            Mage::getSingleton('kasuva/import_cms')->importCms('cms/page', 'pages', $ow);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/kasuva_settings/")); 
        }
    }
?>