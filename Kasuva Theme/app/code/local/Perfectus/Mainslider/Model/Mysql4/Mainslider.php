<?php
class Perfectus_Mainslider_Model_Mysql4_Mainslider extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("mainslider/mainslider", "pslide_id");
    }
	
	protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
		if($object->getId()){
			$select = $this->_getReadAdapter()->select()
				->from($this->getTable('mainslider_store'))
				->where('pslide_id = ?', $object->getId());

			if ($data = $this->_getReadAdapter()->fetchAll($select)) {
				$storesArray = array();
				foreach ($data as $row) {
					$storesArray[] = $row['pslide_store_id'];
				}
				$object->setData('pslide_store_id', $storesArray);
			}
		}
        return parent::_afterLoad($object);
    }
	
	protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
		$stores = (array)$object->getData('stores');
		/*if (!empty($stores))
			{
				foreach ($stores as $storeId)
				{
					$rewriteModel = Mage::getModel('core/url_rewrite');
					$rewriteCollection = $rewriteModel->getCollection();
					$rewriteCollection->addStoreFilter($storeId, false)
									  ->setPageSize(1)
									  ->load();
					if (count($rewriteCollection) > 0)
					{
						foreach ($rewriteCollection as $rewrite) {
							$rewriteModel->setData($rewrite->getData());
						}
					}
					$rewriteModel->setData('store_id', $storeId);
					$rewriteModel->setData('request_path', $object->getUrlKey() . '.html');
					$rewriteModel->setData('id_path', 'mainslider/' . $object->getId());
					
				}
			}
			return parent::_afterSave($object);
		*/
		
		if (!empty($stores)){
			$condition = $this->_getWriteAdapter()->quoteInto('pslide_id = ?', $object->getId());
			$this->_getWriteAdapter()->delete($this->getTable('mainslider_store'), $condition);
			foreach ((array)$object->getData('stores') as $store) {
				$storeArray = array();
				$storeArray['pslide_id'] = $object->getId();
				$storeArray['pslide_store_id'] = $store;
				$this->_getWriteAdapter()->insert($this->getTable('mainslider_store'), $storeArray);
			}
		}
        return parent::_afterSave($object);
		
		
    }
}