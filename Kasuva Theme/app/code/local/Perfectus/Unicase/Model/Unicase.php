<?php
class Perfectus_Fltproducts_Model_Unicase extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('unicase/unicase');
    }
}