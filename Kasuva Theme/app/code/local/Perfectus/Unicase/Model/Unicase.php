<?php
class daeon_Fltproducts_Model_kasuva extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('kasuva/kasuva');
    }
}