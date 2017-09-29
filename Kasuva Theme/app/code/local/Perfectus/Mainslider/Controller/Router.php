<?php
class daeon_Mainslider_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    const MODULE     = 'daeon_Mainslider';
    const CONTROLLER = 'index';
     
    public function initControllerRouters($observer)
    {
        $front = $observer->getEvent()->getFront();

        $router = new daeon_Mainslider_Controller_Router();
        $front->addRouter('mainslider', $router);
    }

    public function match(Zend_Controller_Request_Http $request)
    {
		
		$helper = Mage::helper('mainslider');
        $route = $helper->getRoute();

        /*  redirect if store was changed  */
        $helper->ifStoreChangedRedirect();
        
        $identifier = trim($request->getPathInfo());
        
        if (substr(str_replace("/", "", $identifier), 0, strlen($route)) != $route) {
            return false;
        }

        $identifier = substr_replace($request->getPathInfo(), '', 0, strlen("/" . $route . "/"));
        $identifier = str_replace('.html', '', $identifier);
        $identifier = str_replace('.htm', '', $identifier);

        if ($identifier == '') {
            $request->setModuleName('mainslider')
                ->setControllerName('index')
                ->setActionName('index');
            return true;
        }

        if (strpos($identifier, '/')) {
            $page = substr($identifier, strpos($identifier, '/') + 1);
        }
        
         return false;
    }
}
