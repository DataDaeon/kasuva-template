<?php
class daeon_Megamenu_Helper_Data extends Mage_Core_Helper_Abstract
{
    private $_menuData = null;
	private $_mobileContentArray = array();
	private $_menuContentArray   = array();
	private $_sidemenuContentArray   = array();
	private $_menuBeforeBlock    = null;
	private $_menuAfterBlock    = null;	
	private $_block = null;
	private $_catModel = null;
	private $_categories = null;
	public function getCfg($name = null)
	{
		if($name){
			$name='daeon_megamenu/'.$name;
			return Mage::getStoreConfig($name, Mage::app()->getStore()->getId());
		}
		return null;
	}
    public function saveCurrentCategoryIdToSession()
    {
        $currentCategory = Mage::registry('current_category');
        $currentCategoryId = 0;
        if (is_object($currentCategory)) {
            $currentCategoryId = $currentCategory->getId();
        }
        Mage::getSingleton('catalog/session')
            ->setCustomMenuCurrentCategoryId($currentCategoryId);
    }

    public function initCurrentCategory()
    {
        $currentCategoryId = Mage::getSingleton('catalog/session')->getCustomMenuCurrentCategoryId();
        $currentCategory = null;
        if ($currentCategoryId) {
            $currentCategory = Mage::getModel('catalog/category')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($currentCategoryId);
        }
        Mage::unregister('current_category');
        Mage::register('current_category', $currentCategory);
    }

    public function getMenuData(){
        if (!is_null($this->_menuData)) return $this->_menuData;
		
		if(!$this->_block) {
			$blockClassName = Mage::getConfig()->getBlockClassName('megamenu/navigation');
			$this->_block = new $blockClassName();
		}
		
		if (!$this->_catModel) {
			$this->_catModel = Mage::getModel('catalog/category');
		}
		
        $categories = $this->_block->getStoreCategories();
        if (is_object($categories)) $categories = $categories->getNodes();
        $this->_menuData = array(
            '_block'                        => $this->_block,
            '_categories'                   => $categories,
            '_showHomeLink'                 => $this->getCfg('general/show_home_link'),
			'_showsidebarHomeLink'          => $this->getCfg('general/showsidebar_home_link'),
            '_mobileMenuEnabled'            => $this->getCfg('general/mobile_menu'),
			'_webMenuEnabled'               => $this->getCfg('general/web_menu'),
			'_navmenuBeforeBlock'           => $this->getCfg('general/navmenu_before_block'),
			'_navmenuAfterBlock'            => $this->getCfg('general/navmenu_after_block'),
        );
		
		foreach ($categories as $_category) {
			$catInfo = $this->_catModel->load($_category->getId());
			$cat_menus = $catInfo->getData('pu_megamenu_menu_status');
			$cat_vmenus = $catInfo->getData('pu_megamenu_vmenu_status');
			$cat_menus = ($cat_menus!='')? $cat_menus : 1;
			$cat_vmenus = ($cat_vmenus!='')? $cat_vmenus : 1;
			if($cat_menus==1 || $cat_vmenus==1){
				$htmlArray = $this->_block->drawMegamenuItem($_category, $catInfo);
				if(isset($htmlArray['web']) && $htmlArray['mob']){
					if($cat_menus){
						$this->_menuContentArray[]= $htmlArray['web'];
						$this->_mobileContentArray[] = $htmlArray['mob'];
					}
					if($cat_vmenus){
						$this->_sidemenuContentArray[]= $htmlArray['web'];
					}
				}
			}
        }
		
		//Nav Menu Before Block
		if(!$this->_menuBeforeBlock){
			$this->_menuBeforeBlock = $this->getStaticBlocks($this->getCfg('general/navmenu_before_block'));
		}
		
		//Nav Menu After Block
		if(!$this->_menuAfterBlock){
			$this->_menuAfterBlock = $this->getStaticBlocks($this->getCfg('general/navmenu_after_block'));
		}
		
        return $this->_menuData;
    }

	//Get Menu content
    public function getMenuContent(){
        $menuData = $this->getMenuData();
        extract($menuData);
		$homeLink='';
		//Home Link      
        $homeLink = $this->getHomeLink($_showHomeLink);
		
		$navmenuBeforeBlock = $this->_menuBeforeBlock;
		$navmenuAfterBlock  =  $this->_menuAfterBlock;
		
        //Menu Content
        $menuContent        = '';
		if (count($this->_menuContentArray)) {
            $menuContent = implode("\n", $this->_menuContentArray);
        }
		
        // --- Menu ---
        $htmlMenu = <<<HTML
$navmenuBeforeBlock
$homeLink
$menuContent
$navmenuAfterBlock
HTML;
        return $htmlMenu;
    }
	
	//get Sidebar Menu
	public function getSideMenuContent()
    {
        $menuData = $this->getMenuData();
        extract($menuData);
		
        // --- Menu Content ---
        $menuContent        = '';
		if (count($this->_sidemenuContentArray)) {
            $menuContent = implode("\n", $this->_sidemenuContentArray);
        }
		
        // --- Menu ---
        $htmlMenu = <<<HTML
$menuContent
HTML;
        return $htmlMenu;
    }
	
	 public function getMobileMenuContent(){
	
        $menuData = $this->getMenuData();
        extract($menuData);
        if (!$_mobileMenuEnabled) return '';
        
		//Home Link      
        $homeLink = $this->getHomeLink($_showHomeLink);
		
		$navmenuBeforeBlock = $this->_menuBeforeBlock;
		$navmenuAfterBlock  =  $this->_menuAfterBlock;
		
        // --- Menu Content ---
        $mobileMenuContent = '';
        if (count($this->_mobileContentArray)) {
            $mobileMenuContent = implode("\n", $this->_mobileContentArray);
        }
        // --- Result ---
        $menu = <<<HTML
$navmenuBeforeBlock
$homeLink
$mobileMenuContent
$navmenuAfterBlock
HTML;
        return $menu; 
    }
	
	 //get home page link
	public function getHomeLink($_showHomeLink)
    {
        $store = Mage::app()->getStore();
        $store_id  = $store->getId();

        $menuData = $this->getMenuData();
        extract($menuData);
        $homeLinkUrl        = Mage::app()->getStore($store_id)->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);
        $homeLinkText       = $this->__('Home');
        $homeLink           = '';
		$homeIcon           = '';
        $homeLnkClass      = '';
		$homeLnkClass .= ($this->getIsHomePage()) ? 'act ' : '';
        $homeLnkClass .= 'home '.$_showHomeLink;
        if ($_showHomeLink) {
			if($_showHomeLink=='icon' || $_showHomeLink=='lnk-icon'){
				$homeIcon .= '<span class="icon"><i class="fa fa-home"></i></span>';
			}
			if($_showHomeLink=='lnk' || $_showHomeLink=='lnk-icon'){
				$homeIcon .= '<span class="text">'.$homeLinkText.'</span>';
			}
            $homeLink = <<<HTML
<li class="$homeLnkClass">
    <a href="$homeLinkUrl">
	   $homeIcon
    </a>
</li>
HTML;
            return $homeLink;
        }
        return '';
    }
	
    //is home page
	public function getIsHomePage()
    {
        if(Mage::app()->getFrontController()->getRequest()->getActionName()=='index' && Mage::app()->getFrontController()->getRequest()->getRouteName()=='cms' && Mage::app()->getFrontController()->getRequest()->getControllerName()=='index')
            return true;
        return false;
    }
	
	//get static blocks
	public function getStaticBlocks($blockId)
    {
		if($blockId!=''){
			$block = trim(Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHtml());
			if($block!='&nbsp;'){
				return $block;
			}
		}
        return '';
    }
}
