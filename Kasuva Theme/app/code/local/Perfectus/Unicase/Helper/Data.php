<?php
class daeon_kasuva_Helper_Data extends Mage_Core_Helper_Abstract{
	
    // Category Search
    public function getSearchByCategories($parent, $curId){
		$result = '';
		
		if($parent->getLevel() == 1){
            //$result = '<li class="root_cat level_'.$parent->getLevel().'"><a href="javascript:void(0);" data-val="0">'.$this->getSearchByCatName($parent).'"</a></li>';
			$result = '';
		}
        else if($parent->getLevel() == 2){
			$result .= '<option class="parent_cat level_'.$parent->getLevel().' menu-header">'.$this->getSearchByCatName($parent).'</option>';
		}else {
			$result .= '<option class="child_cat level_'.$parent->getLevel();
			if($curId){
				if($curId	==	$parent->getId()) $result .= " active";
			}
			$result .= '" >'.$this->getSearchByCatName($parent).'</option>';	
		}
		
	
		try{
			$children = $parent->getChildrenCategories();
			if(count($children) > 0){
				foreach($children as $cat){
					$result .= $this->getSearchByCategories($cat, $curId);
				}
			}
		}
		catch(Exception $e){
			return '';
		}
		return $result;
	}
	
	public function getSearchByCatName($category){
		$level = $category->getLevel();
		$html = '';
		if($level > 2){
			for($i = 1;$i < $level;$i++){
				$html .= '-';
			}
		}
		return $html.' '.$category->getName();
	}
	public function getProductLabel(Mage_Catalog_Model_Product $product){
		$html='';
		$sale_flag=false;
		$tmpCfg = Mage::registry('tmpCfg');
		$cfg_sale = $tmpCfg['set']['product_labels']['sale'];
		$cfg_new = $tmpCfg['set']['product_labels']['new'];
		if($cfg_new){
			$now = date("Y-m-d");
            $newsFrom= substr($product->getData('news_from_date'),0,10);
            $newsTo=  substr($product->getData('news_to_date'),0,10);
            if ($newsTo != '' || $newsFrom != ''){
				if (($now>=$newsFrom && $now<=$newsTo) || ($newsTo == '' && $now >=$newsFrom) || ($newsFrom == '' && $now<=$newsTo)){
					$html.='<div class="tag new"><span>'.$this->__('New').'</span></div>';
				}
			}
		}
		if($cfg_sale){
			$specialprice = $product->getSpecialPrice();
			$specialPriceFromDate = $product->getSpecialFromDate();
			$specialPriceToDate = $product->getSpecialToDate();
			$today =  time();
			if($specialprice){
				if($today >= strtotime( $specialPriceFromDate) && $today = strtotime( $specialPriceFromDate) && is_null($specialPriceToDate)){
					$sale_flag=true;
				}
			}
			if($sale_flag==true && $cfg_sale==1){
				$html='<div class="tag sale"><span>'.$this->__('Sale').'</span></div>';
			}else if($sale_flag==true && $cfg_sale==2){
				$originalPrice = $product->getPrice();
				$finalPrice = $product->getFinalPrice();
				$percentage = 0;
				if ($originalPrice > $finalPrice) {
					$percentage = ($originalPrice - $finalPrice) * 100 / $originalPrice +0;
				}

				if ($percentage) {
					$html='<div class="tag sale"><span>'.$this->__('%s','-'.((number_format($percentage, 2, '.', ','))+0). '%').'</span></div>';
				}
			}
		}
		return $html;
	}
	public function getElevateCfg()
	{
		$cfgoptions=Mage::helper('kasuva/config')->getTpcfg('kasuva_settings/product_info');
		$elevatecfg=array();
		$elevatecfg['gallery']='product-image-thumbs';
		$elevatecfg['cursor']=($cfgoptions['elevate_cursor'])? $cfgoptions['elevate_cursor'] : 'default';
		$elevatecfg['galleryActiveClass']='active';
		$elevatecfg['zoomType']=($cfgoptions['zoom_type'])? $cfgoptions['zoom_type'] : 'window';
		if($cfgoptions['zoom_type']=='window'){
			$elevatecfg['zoomWindowWidth']=($cfgoptions['zoom_window_width'])? $cfgoptions['zoom_window_width'] : 400;
			$elevatecfg['zoomWindowHeight']=($cfgoptions['zoom_window_height'])? $cfgoptions['zoom_window_height'] : 400;
			$elevatecfg['tint']=($cfgoptions['elevate_tint'])? $cfgoptions['elevate_tint'] : false;
			$elevatecfg['tintColour']=($cfgoptions['elevate_tint_color'])? "#".$cfgoptions['elevate_tint_color'] : '#333';
			$elevatecfg['tintOpacity']=($cfgoptions['elevate_tint_opacity'])? $cfgoptions['elevate_tint_opacity'] : 0.4;
		}
		$elevatecfg['borderSize']=($cfgoptions['elevate_bordersize'])? $cfgoptions['elevate_bordersize'] : '4';
		$elevatecfg['borderColour']=($cfgoptions['elevate_bordercolor'])? "#".$cfgoptions['elevate_bordercolor'] : '#888';
		//$elevatecfg['loadingIcon']= Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'frontend/daeon/kasuva/images/elevate-spinner.gif';
		$elevatecfg['scrollZoom']=($cfgoptions['elevate_scrollzoom'])? $cfgoptions['elevate_scrollzoom'] : false;
		//$elevatecfg['imageCrossfade']=($cfgoptions['elevate_imagecrossfade'])? $cfgoptions['elevate_imagecrossfade'] : false;
		$elevatecfg['imageCrossfade']=false;
		$elevatecfg['easing']=($cfgoptions['elevate_easing'])? $cfgoptions['elevate_easing'] : false;
		$elevatecfg['easingDuration']=($cfgoptions['elevate_easingduration'])? $cfgoptions['elevate_easingduration'] : 2000;
		$elevatecfg['lensSize']=($cfgoptions['elevate_lenssize'])? $cfgoptions['elevate_lenssize'] : 200;
		$elevatecfg['lensShape']=($cfgoptions['elevate_lenstype'])? $cfgoptions['elevate_lenstype'] : 'square';
		$elevatecfg['zoomTintFadeIn']=200;
		$elevatecfg['zoomTintFadeOut']=200;
		$elevatecfg['zoomWindowFadeIn']=200;
		$elevatecfg['zoomWindowFadeOut']=200;
		$elevatecfg['zoomWindowOffetx']=5;
		$elevatecfg['containLensZoom']=true;
		$elevatecfg['responsive']=true;

		return $elevatecfg;
	}
	public function getTemplateLayout($th){
		$layout=$th->getLayout()->getBlock('root')->getTemplate();
		$layout=str_replace(".phtml",'',$layout);
		$layout=str_replace("page/",'',$layout);
		return $layout;
	}
	public function getIsHomePage()
    {
        $controller = Mage::app()->getRequest()->getControllerName();
        $route = Mage::app()->getFrontController()->getRequest()->getRouteName();
        $action = Mage::app()->getRequest()->getActionName();
        if ($route == 'cms' && $controller=='index' && $action != 'noRoute') {return true;}
        return false;
    }
	public function getColsClass($d,$num){
		$numcol=12/$num;
		$class='';
		$layout=Mage::helper('kasuva')->getTemplateLayout($this);

		if(in_array($num,array(1,2,3,4,6))){
			$class='col-'.$d.'-'.$numcol;
		}else if($num==5){
			$class='col-'.$d.'-pu-5';
		}
		return $class;
	}
	public function getProdAltImg($_product, $w, $h, $imgtype="image", $type = 'slider' ){
		$attributes = $_product->getTypeInstance(true)->getSetAttributes($_product);
		$media_gallery = $attributes['media_gallery'];
		$backend = $media_gallery->getBackend();
		$backend->afterLoad($_product); 
		//$_product->load('media_gallery');
		$blank_gif = Mage::getDesign()->getSkinUrl('images/blank.gif');
		$column = 'position';
		$maxDisImg = 2;
		$gal = $_product->getMediaGalleryImages();
		if(count($gal) >=$maxDisImg ){
			if ($altImg = $gal->getItemByColumnValue($column, $maxDisImg)){
				if($type == 'slider')
					return '<img class="alt-img lazyOwl" src="'.$blank_gif.'" data-src="' . $this->getProdImg($_product, $w, $h, $imgtype, $altImg->getFile()).'" alt="'.$_product->getName(). '" />';
				else
					return '<img class="alt-img lazyImg loading" src="'.$blank_gif.'" data-echo="' . $this->getProdImg($_product, $w, $h, $imgtype, $altImg->getFile()).'" alt="'.$_product->getName(). '" />';
			}
		}
		return '';
	}
	public function getProdImg($_product, $w, $h,$imgtype="image", $file=NULL){
		if($h<=0){
			return Mage::helper('catalog/image')->init($_product, $imgtype, $file)->constrainOnly(false)->keepAspectRatio(true)->keepFrame(false)->resize($w);
		}else{
			return Mage::helper('catalog/image')->init($_product, $imgtype, $file)->resize($w, $h);
		}
	}
}