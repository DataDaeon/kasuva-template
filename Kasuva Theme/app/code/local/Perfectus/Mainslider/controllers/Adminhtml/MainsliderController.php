<?php
class Perfectus_Mainslider_Adminhtml_MainsliderController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()
				->_setActiveMenu("mainslider/mainslider")
				->_addBreadcrumb(Mage::helper("adminhtml")->__("Mainslider  Manager"),Mage::helper("adminhtml")->__("Mainslider Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Mainslider"));
			    $this->_title($this->__("Manager Mainslider"));
				$this->_initAction()->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Mainslider"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("mainslider/mainslider")->load($id);
				if ($model->getId() || $id == 0) {
					$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
					if (!empty($data)) {
						$model->setData($data);
					}
					if($model->getPslideImage()!=''){
						$img = 'perfectus'. DS . 'mainslider' .DS. $model->getPslideImage();
						$model->setPslideImage($img);
					}
					Mage::register("mainslider_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("mainslider/mainslider");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Mainslider Manager"), Mage::helper("adminhtml")->__("Mainslider Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Mainslider Description"), Mage::helper("adminhtml")->__("Mainslider Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("mainslider/adminhtml_mainslider_edit"))->_addLeft($this->getLayout()->createBlock("mainslider/adminhtml_mainslider_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("mainslider")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
				
		}

		public function newAction() {
			$this->_forward('edit');
		}
		public function saveAction()
		{
			$post_data=$this->getRequest()->getPost();
				if ($post_data) {
					try {
						 //save image
						try{
							if((bool)$post_data['pslide_image']['delete']==1) {
								$post_data['pslide_image']='';
							}
							else {
									unset($post_data['pslide_image']);
									if(isset($_FILES)){
										if($_FILES['pslide_image']['name']) {
											if($this->getRequest()->getParam("id")){
											$model = Mage::getModel("mainslider/mainslider")->load($this->getRequest()->getParam("id"));
											if($model->getData('pslide_image')){
													$io = new Varien_Io_File();
													$io->rm(Mage::getBaseDir('media').DS.implode(DS,explode('/',$model->getData('pslide_image'))));	
											}
										}
										$path = Mage::getBaseDir('media') . DS .'perfectus'. DS . 'mainslider' .DS;
										$uploader = new Varien_File_Uploader('pslide_image');
										$uploader->setAllowedExtensions(array('jpg','png','gif'));
										$uploader->setAllowRenameFiles(false);
										$uploader->setFilesDispersion(false);
										$destFile = $path.$_FILES['pslide_image']['name'];
										$filename = $uploader->getNewFileName($destFile);
										$filename=$uploader->save($path, $filename);
										if($filename['file']){
											$filename=$filename['file'];
										}
										$post_data['pslide_image']=$filename;
									}
								}
							}

						} catch (Exception $e) {
								Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
								$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
								return;
						}
						//save image
						$model = Mage::getModel("mainslider/mainslider");
						$model->addData($post_data)->setId($this->getRequest()->getParam("id"));
						
						if ($model->getCreatedAt() == NULL || $model->getUpdatedAt() == NULL) {
							$model->setCreatedAt(now())->setUpdatedAt(now());
						}else {
							$model->setUpdatedAt(now());
						}
						
						$model->save();
						
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Slide has been successfully saved."));
						Mage::getSingleton("adminhtml/session")->setMainsliderData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setMainsliderData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}
		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("mainslider/mainslider");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Slide has been successfully deleted."));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'PerfectusMainslider.csv';
			$grid       = $this->getLayout()->createBlock('mainslider/adminhtml_mainslider_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'PerfectusMainslider.xml';
			$grid       = $this->getLayout()->createBlock('mainslider/adminhtml_mainslider_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
		
		
		protected function _customerExists($mainslidercode, $websiteId = null)
		{
			$mainslider = Mage::getModel('mainslider/mainslider');
			if ($websiteId) {
				$customer->setWebsiteId($websiteId);
			}
			$mainslider->loadByVcode($mainslidercode);
			if ($mainslider->getBfmainsliderId()) {
				return $mainslider;
			}
			return false;
		}
		
		public function massDeleteAction() {
			$tourism_ids = $this->getRequest()->getParam('mainslider');
			if(!is_array($tourism_ids)) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
			} else {
				try {
					foreach ($tourism_ids as $galleryId) {
						$tourisms = Mage::getModel('mainslider/mainslider')->load($galleryId);
						$tourisms->delete();
					}
					Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')->__(
							'Total of %d record(s) were successfully deleted', count($tourism_ids)
						)
					);
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				}
			}
			$this->_redirect('*/*/index');
		}
		
		 public function massStatusAction()
		{
			$tourism_ids = $this->getRequest()->getParam('mainslider');
			$status=$this->getRequest()->getParam('pslide_status');
			if($status==2){$status=0;}
			if(!is_array($tourism_ids)) {
				Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
			} else {
				try {
					foreach ($tourism_ids as $item) {
						$tourisms = Mage::getSingleton('mainslider/mainslider')
							->load($item)
							->setTourismStatus($status)
							->setIsMassupdate(true)
							->save();
					}
					$this->_getSession()->addSuccess(
						$this->__('Total of %d record(s) were successfully updated', count($tourism_ids))
					);
				} catch (Exception $e) {
					$this->_getSession()->addError($e->getMessage());
				}
			}
			$this->_redirect('*/*/index');
		}
}
