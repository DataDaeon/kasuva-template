<?php
class daeon_Mainslider_Model_Mysql4_Mainslider_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct(){
		parent::_construct();
		$this->_init("mainslider/mainslider");
	}
	public function addStoreFilter($store)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        $this->getSelect()->join(
            array('store_table' => $this->getTable('mainslider_store')),
            'main_table.pslide_id = store_table.pslide_id',
            array()
        )
            ->where('store_table.pslide_store_id in (?)', array(0, $store));

        return $this;
    }
}	 
