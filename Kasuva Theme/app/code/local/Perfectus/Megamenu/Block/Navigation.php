<?php
class Perfectus_Megamenu_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    protected static $_productsCount  = null;
    protected static $_popupMenu      = array();
	protected static $_MGHelper       = array();
	protected static $_MGConfig       = array();
	protected static $_keyCurrent     = null;
	protected static $_catModel       = null;
	
	public function __construct() {
		if (!$this->_MGHelper) {
			$this->_MGHelper = Mage::helper('megamenu');
		}
		if (!$this->_MGConfig) {
			$this->_MGConfig = $this->_MGHelper->getCfg('general');
		}
		if (!$this->_keyCurrent) {
			$this->_keyCurrent = $this->getCurrentCategory()->getId();
		}
		if (!$this->_catModel) {
			$this->_catModel = Mage::getModel('catalog/category');
		}
    }

    public function drawMegamenuItem($category, $catInfo, $mode = 'li', $level = 0, $last = false){
        if (!$category->getIsActive()) return;
        $html = array();
		$dropdownClass=$blockHtml='';
        $catId = $category->getId();
		//$catInfo = $this->_catModel->load($catId);
		//category model
		//$catinfo = $this->_getCatInfo($catId);
		//Menu type
		$block_type = $catInfo->getData('pu_megamenu_menu_type');
		if(!$block_type || $block_type=='default'){
			$block_type=$this->_MGConfig['default_menu_type'];
		}
		if($mode == 'mb'){
			$block_type = 'mobile';
		}
		
		$block_top=$block_right=$block_bottom=$block_left='';
		if($block_type=='full_width' || $block_type=='custom' ){
			if($level == 0) {
				$block_left=$this->_getCatBlocks($catInfo, 'pu_mg_lblock_content');
				$block_left_cols=$this->_getCatBlocks($catInfo, 'pu_mg_lblock_cols');
				$block_right=$this->_getCatBlocks($catInfo, 'pu_mg_rblock_content');
				$block_right_cols=$this->_getCatBlocks($catInfo, 'pu_mg_rblock_cols');
				$block_top=$this->_getCatBlocks($catInfo, 'pu_mg_tblock_content');
				$block_bottom=$this->_getCatBlocks($catInfo, 'pu_mg_bblock_content');
			}
		}
		$name = $this->escapeHtml($category->getName());
		
		//Sub Categories ---
		$activeChildren = $this->_getActiveChildren($category, $level);
		
		//class for active category ---
		$active = ''; if ($this->isCategoryActive($category)) $active = ' act';
		//Popup functions for show 
		
		//Category Label
		if($mode!='mb'){
			$cat_label=$this->_getCatLabel($catInfo,$level);
		}
		
		//Category Icon
		$caticon_html='';
		$cat_icon=$catInfo->getData('pu_mg_icon');
		if($cat_icon){
			$caticon_html='<span class="icon"><i class="'.$cat_icon.'"></i></span>';
		}
		
		
		$drawPopup = ($blockHtml || $block_left || $block_right || $block_top || $block_bottom || count($activeChildren));
		
		if($drawPopup){
			if($block_type=='full_width'){
				$dropdownClass='pu-full pu-fc';
			}else if($block_type=='dropdown'){
				$dropdownClass='pu-dropdown';
			}else if($block_type=='custom'){
				$dropdownClass='pu-custom pu-fc';
			}
			$_catUrl = $this->getCategoryUrl($category);

			//web view
			$html['web'][]= '<li id="menu_' . $catId . '" class="level'.$level.' menu' . $active.' '.$dropdownClass.' ">';
			$html['web'][]= '<a  class="level' . $level . $active . '" href="'.$_catUrl.'">'.$caticon_html.'<span>'.$name.'</span>'.$cat_label.'</a>';
			
			//mobile view
			$html['mob'][] = '<li id="menu_' . $catId . '" class="level'.$level.' menu' . $active.'">';
			$html['mob'][] = '<a  class="level' . $level . $active . '" href="'.$_catUrl.'">'.$caticon_html.'<span>'.$name.'</span></a>';
			
			if ($mode != 'mb') {
				if($block_type == 'custom'){
					//MG Custom Width
					$cus_width=$catInfo->getData('pu_mg_cus_width');
					if($cus_width==''){
						$cus_width='800';
					}
					$html['web'][] = '<div class="nav-dropdown" style="display: none; width:'.$cus_width.';">';
					$html['web'][] = '<div class="container">';
				} else {
					$html['web'][] = '<div class="nav-dropdown" style="display: none;">';
					$html['web'][] = '<div class="container">';
				}
			}
			if($level == 0){
				$columns = '';
				if (($block_type == 'full_width' || $block_type == 'custom') ) {
					//draw Sub Categories ---
					if (count($activeChildren)) {
						$columns = (int)$catInfo->getData('pu_mg_cols');
						if(!$columns){
							$columns = (int)$this->_MGConfig['default_menu_columns'];
							if(!$columns){
								$columns=6;
							}
						}
					}
				}
				
				$html_ar = $this->drawColumns($activeChildren, $columns, count($activeChildren), '', $block_type, $mode);
				
				if (($block_type == 'full_width' || $block_type == 'custom') ) {
					if($block_top){
						$html['web'][] = '<div class="pu-top-block">' . $block_top . '</div>';
					}
					
					//Popup function for hide ---
					$html['web'][] = '<div id="popup' . $catId . '" class="pu-main-content">';
					
					if ($block_left){
						$html['web'][] = '<div class="pu-left-block col-sm-'.$block_left_cols.'">' . $block_left . '</div>';
					}
						
					//draw Sub Categories ---
					if (count($activeChildren)) {
										
						//columns item width
						$columnsWidth = 12;
						if ($block_left){
							$columnsWidth = $columnsWidth - $block_left_cols;
						}
						if ($block_right){
							$columnsWidth = $columnsWidth - $block_right_cols;
						}
						
						$html['web'][] = '<div class="block1 col-sm-'.$columnsWidth.'">';
						$html['web'][] = '<div class="row">';                    
						$html['web'][] = '<ul>';
						$html['web'][] = $this->multi_implode($html_ar['web']);
						$html['web'][] = '</ul>';
						$html['web'][] = '</div>';
						$html['web'][] = '</div>';
					}
					
					if ($block_right){
						$html['web'][] = '<div class="pu-right-block col-sm-'.$block_right_cols.'">' . $block_right . '</div>';
					}
					$html['web'][] = '</div>';
					if ($block_bottom){
						$html['web'][] = '<div class="pu-bottom-block">' . $block_bottom . '</div>';
					}
				}else if (($block_type == 'mobile' || $block_type=='dropdown')) {                
					$html['web'][]= '<ul>';
					$html['web'][]=  $this->multi_implode($html_ar['web']);
					$html['web'][]= '</ul>';
				}
				
				//mobile content
				$html['mob'][] = '<ul>';
				$html['mob'][] = $this->multi_implode($html_ar['mob']);
				$html['mob'][] = '</ul>';
			}
			if ($mode != 'mb') {
				$html['web'][] = '</div>';
				$html['web'][] = '</div>';   
			}
			$html['web'][]= $html['mob'][] = '</li>';
		}else {
			//no subcategories and static blocks
			$html['web'][]= $html['mob'][] = '<li class="'.$active.'">';
			$html['web'][]= $html['mob'][] = '<a href="'.$this->getCategoryUrl($category).'">'.$caticon_html.$name.'</a>';
			$html['web'][]= $html['mob'][] = '</li>';
		}
			
		if(isset($html['web']) && isset($html['mob'])){
			$html['web'] = implode("\n", (array)$html['web']);
			$html['mob'] = implode("\n", (array)$html['mob']);
		}
        return $html;
    }
    public function drawMenuItem($children, $level = 1, $type, $width, $mode = 'li')
    {
        //$html = array();
        $keyCurrent = $this->_keyCurrent;
        foreach ($children as $child) {
            if (is_object($child) && $child->getIsActive()) {
                //class for active category ---
                $active = '';
				$activeChildren = $this->_getActiveChildren($child, $level);
                if ($this->isCategoryActive($child)) {
                    $active = ' actParent';
                    if ($child->getId() == $keyCurrent) $active = ' act';
                }
				$catInfo = $this->_catModel->load($child->getId());
				
				// ---Categor Label
                $cat_label=$this->_getCatLabel($catInfo, $level);
				
                //format category name ---
                $name = $this->escapeHtml($child->getName());
				$class='menu-item';
				if (count($activeChildren) > 0) {
                    $class .= ' has-children parent';
                }
				
				//category status
				$cat_status = $catInfo->getData('pu_megamenu_menu_status');
				$cat_status=($cat_status!='') ? $cat_status : 1;
				
				if($cat_status){
					
					$_catChildUrl = $this->getCategoryUrl($child);
					if ($level == 1) {
						if ($type == 'full_width' || $type == 'custom' && $width!='') {
							$class .= ' pu-sm-'.$width;
						}
						$html['web'][] = $html['mob'][] = '<li class="'.$class.' '.$active.' ">';
						$html['web'][] = $html['mob'][] = '<a class="level' . $level . '" href="' . $_catChildUrl . '"><span>' . $name .'</span>'.$cat_label.'</a>';    
					} else {
						$html['web'][] = $html['mob'][] = '<li class="'.$class.' '.$active.'">';
						$html['web'][] = $html['mob'][] = '<a class="level' . $level . '" href="' . $_catChildUrl . '"><span>' . $name . '</span>'.$cat_label.'</a>';
					}
					
					if (count($activeChildren) > 0){
						$html['web'][] =  '<div class="nav-child-dropdown level' . $level . '">';
						if ($mode != 'mb') {
							if ($level == 1) {
								$catThumb = $catInfo->getThumbnail();
								if ($type == 'full_width' && $catThumb) {
									$html['web'][] = '<div class="menu_thumb_img">';
									$html['web'][] =  '<a class="menu_thumb_link" href="'. $_catChildUrl .'">';
									$html['web'][] =  '<img src="' . Mage::getBaseUrl('media').'catalog/category/' . $catThumb . '" alt="' . Mage::helper('catalog/output')->__("Thumbnail Image").'" />';
									$html['web'][] =  '</a>';
									$html['web'][] =  '</div>';
								}
							}
						}
						$html['web'][] = $html['mob'][] = '<ul>';
						$html_ar = $this->drawMenuItem($activeChildren, $level + 1, $type, $width, $mode);
						$html['web'][] = $html_ar['web'];
						$html['mob'][] = $html_ar['mob'];
						$html['web'][] = $html['mob'][] = '</ul>';                    
						if ($mode != 'mb') {
							$html['web'][] = '</div>';   
						}
					}
					$html['web'][] = $html['mob'][] = '</li>';
				}
				
			}
			
		}
        return $html;
    }

    public function drawColumns($children, $columns = 1, $catNum = 1, $catLabel = '', $type, $mode = 'li')
    {
        //$html = array();
		if ($columns < 1) $colWidth = 4;
		$colWidth = $columns;

        $chunks = $this->_explodeByColumns($children, $columns, $catNum);        

        //draw columns ---
        $lastColumnNumber = count($chunks);        
        $i = 1;
        foreach ($chunks as $key => $value)
        {
            if ($type == 'full_width' || $type="custom" && $mode != 'mb' ) {
                if (!count($value)) continue;            
                $html_ar = $this->drawMenuItem($value, 1, $type, $colWidth);
				
            } else {
                $html_ar = $this->drawMenuItem($value, 1,'','',$mode);
            }
			$html['web'][] = $html_ar['web'];
			$html['mob'][] = $html_ar['mob'];
            $i++;
        }
        return $html;
    }

    public function _getActiveChildren($parent, $level)
    {
        $activeChildren = array();
        //check level ---
        $maxLevel = (int)$this->_MGConfig['max_level'];
        if ($maxLevel > 0)
        {
            if ($level >= ($maxLevel - 1)) return $activeChildren;
        }
        /// check level ---
        if (Mage::helper('catalog/category_flat')->isEnabled())
        {
            $children = $parent->getChildrenNodes();
            $childrenCount = count($children);
        }
        else
        {
            $children = $this->_catModel->getCategories($parent->getId());
            $childrenCount = count($children);
        }
        $hasChildren = $children && $childrenCount;
        if ($hasChildren)
        {
            foreach ($children as $child)
            {
                if ($this->_isCategoryDisplayed($child))
                {
                    array_push($activeChildren, $child);
                }
            }
        }
        return $activeChildren;
    }

    private function _isCategoryDisplayed(&$child)
    {
        if (!$child->getIsActive()) return false;
        // === check products count ===
        //get collection info ---
        if (!$this->_MGConfig['display_empty_categories']) {
            $data = $this->_getProductsCountData();
            //check by id ---
            $catId = $child->getId();
            if (!isset($data[$catId]) || !$data[$catId]['product_count']) return false;
        }
        // === / check products count ===
        return true;
    }

    private function _getProductsCountData()
    {
        if (is_null($this->_productsCount)) {
            $collection = $this->_catModel->getCollection();
            $storeId = Mage::app()->getStore()->getId();
            /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection */
            $collection->addAttributeToSelect('name')
                ->addAttributeToSelect('is_active')
                ->setStoreId($storeId);
			if(method_exists($collection, 'setProductStoreId'))
                $collection->setProductStoreId($storeId);
			if(method_exists($collection, 'setLoadProductCount'))
                $collection->setLoadProductCount(true);

            $productsCount = array();
            foreach($collection as $cat) {
                $productsCount[$cat->getId()] = array(
                    'name' => $cat->getName(),
                    'product_count' => $cat->getProductCount(),
                );
            }
            #Mage::log($productsCount);
            $this->_productsCount = $productsCount;
        }
        return $this->_productsCount;
    }

    private function _explodeByColumns($target, $num, $catNum)
    {
        $target = self::_explodeArrayByColumnsHorisontal($target, $num, $catNum);
        
        #return $target;
//        if ((int)Mage::getStoreConfig('megamenu/columns/integrate') && count($target))
        if (count($target))
        {
            //combine consistently numerically small column ---
            //1. calc length of each column ---
            $max = 0; $columnsLength = array();
            foreach ($target as $key => $child)
            {
                $count = 0;
                $this->_countChild($child, 1, $count);
                if ($max < $count) $max = $count;
                $columnsLength[$key] = $count;
            }
            //2. merge small columns with next ---
            $xColumns = array(); $column = array(); $cnt = 0;
            $xColumnsLength = array(); $k = 0;
            foreach ($columnsLength as $key => $count)
            {
                $cnt+= $count;
                if ($cnt > $max && count($column))
                {
                    $xColumns[$k] = $column;
                    $xColumnsLength[$k] = $cnt - $count;
                    $k++; $column = array(); $cnt = $count;
                }
                $column = array_merge($column, $target[$key]);
            }
            $xColumns[$k] = $column;
            $xColumnsLength[$k] = $cnt - $count;
            //3. integrate columns of one element ---
            $target = $xColumns; $xColumns = array(); $nextKey = -1;
            if ($max > 1 && count($target) > 1)
            {
                foreach($target as $key => $column)
                {
                    if ($key == $nextKey) continue;
                    if ($xColumnsLength[$key] == 1)
                    {
                        //merge with next column ---
                        $nextKey = $key + 1;
                        if (isset($target[$nextKey]) && count($target[$nextKey]))
                        {
                            $xColumns[] = array_merge($column, $target[$nextKey]);
                            continue;
                        }
                    }
                    $xColumns[] = $column;
                }
                $target = $xColumns;
            }
        }
        
        return $target;
    }

    private function _countChild($children, $level, &$count)
    {
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $count++; $activeChildren = $this->_getActiveChildren($child, $level);
                if (count($activeChildren) > 0) $this->_countChild($activeChildren, $level + 1, $count);
            }
        }
    }

    private static function _explodeArrayByColumnsHorisontal($list, $num)
    {
        if ($num <= 0) return array($list);
        $partition = array();
        $partition = array_pad($partition, $num, array());
        $i = 0;
        foreach ($list as $key => $value) {
            $partition[$i][$key] = $value;
            if (++$i == $num) $i = 0;
        }
        return $partition;
    }

    private static function _explodeArrayByColumnsVertical($list, $num)
    {
        if ($num <= 0) return array($list);
        $listlen = count($list);
        $partlen = floor($listlen / $num);
        $partrem = $listlen % $num;
        $partition = array();
        $mark = 0;
        for ($column = 0; $column < $num; $column++) {
            $incr = ($column < $partrem) ? $partlen + 1 : $partlen;
            $partition[$column] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }
	//get static blocks
	public function _getCatBlocks($cat, $block)
    {
        if (!$this->_tplProcessor){ 
            $this->_tplProcessor = Mage::helper('cms')->getBlockTemplateProcessor();            
        }
        return $this->_tplProcessor->filter( trim($cat->getData($block)) ); 
    }
	
	//get category info
	function _getCatInfo($categoryId)
    {
        return Mage::getModel('catalog/category')->load($categoryId);
    }
	
	//get category Label
    function _getCatLabel($cat, $level)
    {
        $label = $cat->getData('pu_mg_label');
        if ($label!='') {
            $labelContent = $this->_MGHelper->getCfg('category_labels/'.$label);
            if ($labelContent) {
                if ($level = 0) {
                    return ' <span class="menu-label '. $label .'  hidden-xs">' . $labelContent . '</span>';
                } else {
                    return ' <span class="menu-label '. $label .'">' . $labelContent . '</span>';
                }
            }
        }
        return '';
    }
	public function getIsHomePage()
    {
        if(Mage::app()->getFrontController()->getRequest()->getActionName()=='index' && Mage::app()->getFrontController()->getRequest()->getRouteName()=='cms' && Mage::app()->getFrontController()->getRequest()->getControllerName()=='index')
            return true;
        return false;
    }
	
	public function multi_implode($html_ar){
		$html = '';
		if(is_array($html_ar)){
			foreach($html_ar as $k => $v ){
				if(is_array($v)){
					$html.= $this->multi_implode($v);
				}else{
					$html.= $v;
				}
			}
		}		
		return $html;
	}
}
