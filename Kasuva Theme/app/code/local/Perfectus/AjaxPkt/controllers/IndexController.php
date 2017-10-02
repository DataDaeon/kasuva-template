<?php
require_once 'Mage/Checkout/controllers/CartController.php';
class Perfectus_AjaxPkt_IndexController extends Mage_Checkout_CartController {
    public function addAction()
    {
        $cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();
        if($params['isAjax'] == 1){
            $response = array();
            try {
                if (isset($params['qty'])) {
                    $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                    );
                    $params['qty'] = $filter->filter($params['qty']);
                }
 
                $product = $this->_initProduct();
                $related = $this->getRequest()->getParam('related_product');
 
                /**
                 * Check product availability
                 */
                if (!$product) {
                    $response['status'] = 'ERROR';
					$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Unable to find Product ID').'</span></li></ul></li></ul>';
                }
 
                $cart->addProduct($product, $params);
                if (!empty($related)) {
                    $cart->addProductsByIds(explode(',', $related));
                }
 
                $cart->save();
 
                $this->_getSession()->setCartWasUpdated(true);
 
                /**
                 * @todo remove wishlist observer processAddToCart
                 */
                Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
                );
 
                if (!$cart->getQuote()->getHasError()){
					$store = Mage::app()->getStore();
                    $code  = $store->getCode();
					$product_img_path = "";
                    $product_img_path=Mage::helper('catalog/image')->init($product, 'small_image')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(138);
					$product_title=Mage::helper('core')->htmlEscape($product->getName());
					$product_image = '<img src="'.$product_img_path.'" class="product-image" alt="'.$product_title.'" title="'.$product_title.'" />';
					$message = '<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__("Product successfully added to your cart.").'</span></li></ul></li></ul><div class="content product"><div class="product-info"><div class="image">'.$product_image.'</div><h3 class="product-name name"><a href="javascript:void(0);">'.$product_title.'</a></h3></div></div><div class="actions"><button type="button" id="continue_shopping" class="btn btn-primary btn-continue-shopping" >'.$this->__("Continue Shopping").'</button><button type="button" id="go_to_cart" class="btn btn-primary btn-gotocart" >'.$this->__("Shopping Cart").'</button></div>';
                    $response['status'] = 'SUCCESS';
                    $response['message'] = $message;
                    //New Code Here
                    $this->loadLayout();
					$cart_sidebar = $toplink = $minicart = '';
                    $toplink = $this->getLayout()->getBlock('top.links')->toHtml();
					if($this->getLayout()->getBlock('cart_sidebar'))
                        $cart_sidebar = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
					if($this->getLayout()->getBlock('minicart_head'))
						$minicart = $this->getLayout()->getBlock('minicart_head')->toHtml();
                    Mage::register('referrer_url', $this->_getRefererUrl());
					$response['minicart'] = $minicart;
                    $response['toplink'] = $toplink;
                    $response['sidebar'] = $cart_sidebar;
					
                }
            } catch (Mage_Core_Exception $e) {
                $msg = "";
                if ($this->_getSession()->getUseNotice(true)) {
                    $msg = $e->getMessage();
                } else {
                    $messages = array_unique(explode("\n", $e->getMessage()));
                    foreach ($messages as $message) {
                        $msg .= $message.'<br/>';
                    }
                }
 
                $response['status'] = 'ERROR';
                $response['message'] = $response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$msg.'</span></li></ul></li></ul>';
            } catch (Exception $e) {
                $response['status'] = 'ERROR';
				$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Cannot add the item to shopping cart.').'</span></li></ul></li></ul>';
                Mage::logException($e);
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
            return;
        }else{
            return parent::addAction();
        }
    }
    public function deleteAction()
    {
		$params = $this->getRequest()->getParams();
        if($params['isAjax']== 1){
            $id = (int) $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $this->_getCart()->removeItem($id)->save(); 
                    $message = '<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__('Item was removed from your shopping cart.').'</span></li></ul></li></ul>';
                    $response['status'] = 'SUCCESS';
                    $response['message'] = $message;
					$this->loadLayout();
					$cart_sidebar = $toplink = $minicart = '';
					$toplink = $this->getLayout()->getBlock('top.links')->toHtml();
					if($this->getLayout()->getBlock('cart_sidebar'))
                        $cart_sidebar = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
					if($this->getLayout()->getBlock('minicart_head'))
						$minicart = $this->getLayout()->getBlock('minicart_head')->toHtml();
                    Mage::register('referrer_url', $this->_getRefererUrl());
					$response['minicart'] = $minicart;
                    $response['toplink'] = $toplink;
                    $response['sidebar'] = $cart_sidebar;
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
                    return;

                } catch (Exception $e) {
					$response['status'] = 'ERROR';
					$response['message'] ='<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Cannot remove the item from shopping cart.').'</span></li></ul></li></ul>';
					Mage::logException($e);
                }
            }
        } else {
            return parent::deleteAction();
        }
    }
    public function optionsAction(){
        $productId = $this->getRequest()->getParam('product_id');
        // Prepare helper and params
        $viewHelper = Mage::helper('catalog/product_view');
 
        $params = new Varien_Object();
        $params->setCategoryId(false);
        $params->setSpecifyOptions(false);
 
        // Render page
        try {
            $viewHelper->prepareAndRender($productId, $this, $params);
        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }
    protected function _getWishlist($wishlistId = null)
    {
        $wishlist = Mage::registry('wishlist');
        if ($wishlist) {
            return $wishlist;
        }
        try {
            if (!$wishlistId) {
                $wishlistId = $this->getRequest()->getParam('wishlist_id');
            }
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            $wishlist = Mage::getModel('wishlist/wishlist');
            
            if ($wishlistId) {
                $wishlist->load($wishlistId);
            } else {
                $wishlist->loadByCustomer($customerId, true);
            }

            if (!$wishlist->getId() || $wishlist->getCustomerId() != $customerId) {
                $wishlist = null;
                Mage::throwException(
                    Mage::helper('wishlist')->__("Requested wishlist doesn't exist")
                );
            }
            
            Mage::register('wishlist', $wishlist);
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('wishlist/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::getSingleton('wishlist/session')->addException($e,
            Mage::helper('wishlist')->__('Cannot create wishlist.')
            );
            return false;
        }
 
        return $wishlist;
    }
    public function addwishAction()
    {
        $response = array();
        if (!Mage::getStoreConfigFlag('wishlist/general/active')) {
            $response['status'] = 'ERROR';
			$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Wishlist Has Been Disabled By Admin').'</span></li></ul></li></ul>';
        }
        if(!Mage::getSingleton('customer/session')->isLoggedIn()){
            $response['status'] = 'ERROR';
            $response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Please Login First').'</span></li></ul></li></ul>';
			
			
        }
 
        if(empty($response)){
            $session = Mage::getSingleton('customer/session');
            $wishlist = $this->_getWishlist();
            if (!$wishlist) {
                $response['status'] = 'ERROR';
				$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Unable to Create Wishlist').'</span></li></ul></li></ul>';
            }else{
 
                $productId = (int) $this->getRequest()->getParam('product');
                if (!$productId) {
                    $response['status'] = 'ERROR';
					$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Product Not Found').'</span></li></ul></li></ul>';
                }else{
 
                    $product = Mage::getModel('catalog/product')->load($productId);
                    if (!$product->getId() || !$product->isVisibleInCatalog()) {
                        $response['status'] = 'ERROR';
						$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('Cannot specify product.').'</span></li></ul></li></ul>';
                    }else{
 
                        try {
                            $requestParams = $this->getRequest()->getParams();
                            if ($session->getBeforeWishlistRequest()) {
                                $requestParams = $session->getBeforeWishlistRequest();
                                $session->unsBeforeWishlistRequest();
                            }
                            $buyRequest = new Varien_Object($requestParams);
 
                            $result = $wishlist->addNewItem($product, $buyRequest);
                            if (is_string($result)) {
                                Mage::throwException($result);
                            }
                            $wishlist->save();
 
                            Mage::dispatchEvent(
                                'wishlist_add_product',
                            array(
                                'wishlist'  => $wishlist,
                                'product'   => $product,
                                'item'      => $result
                            )
                            );
 
                            
                            $referer = $session->getBeforeWishlistUrl();
                            if ($referer) {
                                $session->setBeforeWishlistUrl(null);
                            } else {
                                $referer = $this->_getRefererUrl();
                            }
                            $session->setAddActionReferer($referer);
                            
                            Mage::helper('wishlist')->calculate();
                            
                            $message ='<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__('%1$s has been added to your wishlist.',$product->getName(), Mage::helper('core')->escapeUrl($referer)).'</span></li></ul></li></ul>';
                            $response['status'] = 'SUCCESS';
                            $response['message'] = $message;
 
                            Mage::unregister('wishlist');
							$sidebar = $toplink = $minicart = '';
                            $this->loadLayout();
                            $toplink = $this->getLayout()->getBlock('top.links')->toHtml();
                            $sidebar_block = $this->getLayout()->getBlock('wishlist_sidebar');
                            $sidebar = $sidebar_block->toHtml();
                            $response['toplink'] = $toplink;
                            $response['sidebar'] = $sidebar;
                        }
                        catch (Mage_Core_Exception $e) {
                            $response['status'] = 'ERROR';
							$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()).'</span></li></ul></li></ul>';
                        }
                        catch (Exception $e) {
                            mage::log($e->getMessage());
                            $response['status'] = 'ERROR';
							$response['message'] = '<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('An error occurred while adding item to wishlist.').'</span></li></ul></li></ul>';
                        }
                    }
                }
            }
 
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }
    public function compareAction()
	{
        $response = array();
        
        $productId = (int) $this->getRequest()->getParam('product');
        
        if ($productId && (Mage::getSingleton('log/visitor')->getId() || Mage::getSingleton('customer/session')->isLoggedIn())) {
            $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);
 
            if ($product->getId()/* && !$product->isSuper()*/) {
                Mage::getSingleton('catalog/product_compare_list')->addProduct($product);
                $response['status'] = 'SUCCESS';
                $response['message'] ='<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__('The product %s has been added to comparison list.', Mage::helper('core')->escapeHtml($product->getName())).'</span></li></ul></li></ul>';
                Mage::register('referrer_url', $this->_getRefererUrl());
                Mage::helper('catalog/product_compare')->calculate();
                Mage::dispatchEvent('catalog_product_compare_add_product', array('product'=>$product));
                $this->loadLayout();
				$this->loadLayout();
				$toplink = $this->getLayout()->getBlock('compare_dropdown')->toHtml();
				if($toplink) $response['toplink'] = $toplink;
                $sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
                $sidebar_block->setTemplate('ajaxwishlist/catalog/product/compare/sidebar.phtml');
                $sidebar = $sidebar_block->toHtml();
                $response['sidebar'] = $sidebar;
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }
	public function comdeleteAction()
	{
        $response = array();
        
        $productId = (int) $this->getRequest()->getParam('product');
        
        if ($productId && (Mage::getSingleton('log/visitor')->getId() || Mage::getSingleton('customer/session')->isLoggedIn())) {
            $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);
 
            if ($product->getId()/* && !$product->isSuper()*/) {
                Mage::getSingleton('catalog/product_compare_list')->removeProduct($product);
                $response['status'] = 'SUCCESS';
                $response['message'] ='<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__('The product %s has been removed to comparison list.', Mage::helper('core')->escapeHtml($product->getName())).'</span></li></ul></li></ul>';
                Mage::register('referrer_url', $this->_getRefererUrl());
                Mage::helper('catalog/product_compare')->calculate();
                Mage::dispatchEvent('catalog_product_compare_remove_product', array('product'=>$product));
                $this->loadLayout();
				$this->loadLayout();
				$toplink = $this->getLayout()->getBlock('compare_dropdown')->toHtml();
				if($toplink) $response['toplink'] = $toplink;
                $sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
                $sidebar_block->setTemplate('ajaxwishlist/catalog/product/compare/sidebar.phtml');
                $sidebar = $sidebar_block->toHtml();
                $response['sidebar'] = $sidebar;
            }
        }
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }
	public function comclearAction()
	{
		
		$response = array();
		
		$items = Mage::getResourceModel('catalog/product_compare_item_collection');

        if (Mage::getSingleton('customer/session')->isLoggedIn()) {
            $items->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId());
        } elseif ($this->_customerId) {
            $items->setCustomerId($this->_customerId);
        } else {
            $items->setVisitorId(Mage::getSingleton('log/visitor')->getId());
        }

        /** @var $session Mage_Catalog_Model_Session */
        $session = Mage::getSingleton('catalog/session');

        try {
            $items->clear();
			$response['status'] = 'SUCCESS';
            $response['message'] ='<ul class="messages"><li class="success-msg"><ul><li><span>'.$this->__('The comparison list was cleared.').'</span></li></ul></li></ul>';
            Mage::helper('catalog/product_compare')->calculate();
        } catch (Mage_Core_Exception $e) {
			$response['status'] = 'ERROR';
            $response['message'] ='<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('%s', $e->getMessage()).'</span></li></ul></li></ul>';
        } catch (Exception $e) {
			$response['status'] = 'ERROR';
			$response['message'] ='<ul class="messages"><li class="error-msg"><ul><li><span>'.$this->__('%s', $this->__('An error occurred while clearing comparison list.')).'</span></li></ul></li></ul>';
        }
		Mage::register('referrer_url', $this->_getRefererUrl());
		Mage::helper('catalog/product_compare')->calculate();
		$this->loadLayout();
		$this->loadLayout();
		$toplink = $this->getLayout()->getBlock('compare_dropdown')->toHtml();
		if($toplink) $response['toplink'] = $toplink;
		$sidebar_block = $this->getLayout()->getBlock('catalog.compare.sidebar');
		$sidebar_block->setTemplate('ajaxwishlist/catalog/product/compare/sidebar.phtml');
		$sidebar = $sidebar_block->toHtml();
		$response['sidebar'] = $sidebar;
		
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }
}
