<?php

class Perfectus_Fltproducts_Model_Mysql4_Fltproducts extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('fltproducts/fltproducts', 'fltproducts_id');
    }
}