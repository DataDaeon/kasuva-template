<?php
class Perfectus_Fltproducts_Model_Mysql4_Fltproducts_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('fltproducts/fltproducts');
    }
}