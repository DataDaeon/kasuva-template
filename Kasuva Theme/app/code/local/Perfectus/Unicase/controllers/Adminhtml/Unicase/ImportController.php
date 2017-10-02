<?php 
    class Perfectus_Unicase_Adminhtml_Unicase_ImportController extends Mage_Adminhtml_Controller_Action{ 
        public function indexAction() {
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/unicase_settings/"));
        }
        public function blocksAction() {
            $ow = Mage::helper('unicase/config')->getTpcfg('unicase_settings/theme_install/overwrite_pages');
            Mage::getSingleton('unicase/import_cms')->importCms('cms/block', 'blocks', $ow);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/unicase_settings/"));
        }
        public function pagesAction() {
            $ow = Mage::helper('unicase/config')->getTpcfg('unicase_settings/theme_install/overwrite_pages');
            Mage::getSingleton('unicase/import_cms')->importCms('cms/page', 'pages', $ow);
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/unicase_settings/")); 
        }
    }
?>