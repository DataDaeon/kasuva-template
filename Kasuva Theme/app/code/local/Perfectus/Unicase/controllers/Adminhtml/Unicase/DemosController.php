<?php 
    class daeon_kasuva_Adminhtml_kasuva_DemosController extends Mage_Adminhtml_Controller_Action{
        public function indexAction() {
            $this->getResponse()->setRedirect($this->getUrl("adminhtml/system_config/edit/section/kasuva_settings/"));
        }
        public function importdemosAction() {
            $refererUrl = $this->_getRefererUrl();
            if(empty($refererUrl)){
                $refererUrl = $this->getUrl("adminhtml/system_config/edit/section/kasuva_settings/");
            }
            $demos = $this->getRequest()->getParam('demos');
            $website = $this->getRequest()->getParam('website');
            $store   = $this->getRequest()->getParam('store');
            Mage::getSingleton('kasuva/import_demos')->importDemos($demos,$store,$website);
            $this->getResponse()->setRedirect($refererUrl);
        }
    }
?>