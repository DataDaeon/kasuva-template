<?php
class daeon_Ajaxfilter_Block_Catalog_Layer_Filter_Price extends Mage_Catalog_Block_Layer_Filter_Price 
{
    	
	public $_currentCategory;
	public $_searchSession;
	public $_productCollection;
	public $_maxPrice;
	public $_minPrice;
	public $_currMinPrice;
	public $_currMaxPrice;
	public $_imagePath;
	
	/*
	* 
	* Set all the required data that our ajaxfilter will require
	* Set current _currentCategory, _searchSession, setProductCollection, setMinPrice, setMaxPrice, setCurrentPrices, _imagePath
	* 
	* @set all required data
	* 
	*/
	public function __construct(){
	
		$this->_currentCategory = Mage::registry('current_category');
		$this->_searchSession = Mage::getSingleton('catalogsearch/session');
		$this->setProductCollection();
		$this->setMinPrice();
		$this->setMaxPrice();
		$this->setCurrentPrices();
		$this->_imagePath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'daeon/ajaxfilter/';
		
		parent::__construct();		
	}
	
	/*
	* 
	* Check whether the ajaxfilter is enabled.
	*
	* @return boolean
	* 
	*/
	public function getAjaxfilterStatus(){
		if(Mage::getStoreConfig('price_ajaxfilter/price_ajaxfilter_settings/ajaxfilter_loader_active'))
			return true;
		else
			return false;			
	}
	 
	
	/*
	* Fetch Styles for price text Box
	*
	* @return styles
	*/
	public function getPriceBoxStyle(){
		$styles = trim($this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/textBoxCss'));
		if($styles == ''){
			$styles = "width:50px; padding:5px; border-radius:5px; ";
		}
		return $styles;
	}
	
	public function getGoBtnText(){
		$name = trim($this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/goBtnText'));
		if($name == ''){
			$name = "Go";
		}
		return $name;
	}

	public function getGoBtnStyle(){
		$styles = trim($this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/goBtnCss'));
		return $styles;
	}
	
	public function isTextBoxEnabled(){
		return $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/textbox');	
	}
	
	public function setNewPrices(){
		$this->setInSession('_newCurrMinPrice', $this->_currMinPrice);	
		$this->setInSession('_newCurrMaxPrice', $this->_currMaxPrice);	
		if(!is_numeric($this->_currMinPrice)){
			$this->_currMinPrice = 0;
			$this->setInSession('_currMinPrice', 0);
		}
		
		if(!is_numeric($this->_currMaxPrice)){
			$this->_currMaxPrice = 0;
			$this->setInSession('_currMaxPrice', 0);
		}
		
		$sMin = $this->getFromSession('_minPrice');
		$sMax = $this->getFromSession('_maxPrice');
		$csMin = $this->getFromSession('_currMinPrice');
		$csMax = $this->getFromSession('_currMaxPrice');
		$ncsMin = $this->getFromSession('_newCurrMinPrice');
		$ncsMax = $this->getFromSession('_newCurrMaxPrice');
		
		
		// if Filters are called
			
		$a[0][] = 'price_index.min_price';
		$a[0][] = 'ASC';
		$loadedCollection = $this->getLayout()->getBlockSingleton('catalog/product_list')->getLoadedProductCollection()->setOrder('min_price','DESC')->getSelect()->setPart('order',$a)->query()->fetchAll();
		//print_r(get_class_methods($loadedCollection));exit;
		//echo '<pre>';
		$tot = count($loadedCollection);
		
		//echo $loadedCollection;exit;
		
		if(count($loadedCollection) > 0){
			$loadedMin = $loadedCollection[0]['min_price'];
			$loadedMax = $loadedCollection[$tot-1]['min_price'];	
		}	
		
		
		
				
		if($this->_currMinPrice == $csMin && $this->_currMaxPrice == $csMax){
			
			if($this->_minPrice != $ncsMin){
				$this->setInSession('_minPrice', $loadedMin);
				$this->_minPrice = $loadedMin;
			}
			if($loadedMin >= $csMin){
				$this->_currMinPrice = $loadedMin;
				$this->setInSession('_currMinPrice', $loadedMin);
			}
			if($this->_maxPrice != $ncsMax){
				$this->setInSession('_maxPrice', $loadedMin);
				$this->_maxPrice = $loadedMax;
			}
			if($loadedMax <= $csMax){
				$this->_currMaxPrice = $loadedMax;
				$this->setInSession('_currMaxPrice', $loadedMax);
			}
		}else{
			if($ncsMin == $loadedMin){
				$this->setInSession('_minPrice', $loadedMin);
				$this->_minPrice = $loadedMin;
			}
			if($ncsMax == $loadedMax){
				$this->setInSession('_maxPrice', $loadedMin);
				$this->_maxPrice = $loadedMax;
			}
			
			
				
		}
	}
	
	public function getPriceDisplayType(){
		$textBoxStyle = $this->getPriceBoxStyle();
		$goBtnStyle = $this->getGoBtnStyle();
		if($this->isTextBoxEnabled()){
			$html = '
				<div class="text-box">
					<span class="from-txtbox">'.$this->getCurrencySymbol().' <input type="text" name="min" id="minPrice" class="priceTextBox" value="'.$this->getCurrMinPrice().'" style="'.$textBoxStyle.'" /></span>
					<span class="devider">-</span>
					<span class="to-txtbox">'.$this->getCurrencySymbol().' <input type="text" name="max" id="maxPrice" class="priceTextBox" value="'.$this->getCurrMaxPrice().'" style="'.$textBoxStyle.'" /></span>
					<button name="go" class="go btn-filter button" style="'.$goBtnStyle.'">'.$this->getGoBtnText().'</button>
					<input type="hidden" id="amount" readonly="readonly" style="background:none; border:none;" value="'.$this->getCurrencySymbol().$this->getCurrMinPrice()." - ".$this->getCurrencySymbol().$this->getCurrMaxPrice().'" />

				</div>';
		}else{
			$html = '<span class="min-max"><span class="pull-left">'.$this->getCurrencySymbol().$this->getCurrMinPrice().'</span><span class="pull-right">'.$this->getCurrencySymbol().$this->getCurrMaxPrice().'</span>
            </span>';
		}
		return $html;
	}
	
	/**
	*
	* Prepare html for ajaxfilter and add JS that incorporates the ajaxfilter.
	*
	* @return html
	*
	*/
	
	public function getHtml(){
		
		if($this->getAjaxfilterStatus()){
			//$this->setNewPrices();
			$text='
				<div class="price-range-holder">
					<div id="ajaxfilter-range"></div>
					'.$this->getPriceDisplayType().'
				</div>'.$this->getAjaxfilterJs();	
			
			return $text;
		}	
	}
	
	/*
	* Prepare query string that was in the original url 
	*
	* @return queryString
	*/
	public function prepareParams(){
		$url="";
	
		$params=$this->getRequest()->getParams();
		foreach ($params as $key=>$val)
			{
					if($key=='id'){ continue;}
					if($key=='min'){ continue;}
					if($key=='max'){ continue;}
					$url.='&'.$key.'='.$val;		
			}		
		return $url;
	}
	
	/*
	* Fetch Current Currency symbol
	* 
	* @return currency
	*/
	public function getCurrencySymbol(){
		return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
	}
	
	/*
	* Fetch Current Minimum Price
	* 
	* @return price
	*/
	public function getCurrMinPrice(){
		if($this->_currMinPrice > 0){
			$min = $this->_currMinPrice;
		} else{
			$min = $this->_minPrice;
		}
		return $min;
	}
	
	/*
	* Fetch Current Maximum Price
	* 
	* @return price
	*/
	public function getCurrMaxPrice(){
		if($this->_currMaxPrice > 0){
			$max = $this->_currMaxPrice;
		} else{
			$max = $this->_maxPrice;
		}
		return $max;
	}
	
	/*
	* Get Ajaxfilter Configuration TimeOut
	* 
	* @return timeout
	*/
	public function getConfigTimeOut(){
		return $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/timeout');
	}
	
	
	/*
	* Gives you the current url without parameters
	* 
	* @return url
	*/
	public function getCurrentUrlWithoutParams(){
		$baseUrl = explode('?',Mage::helper('core/url')->getCurrentUrl());
		$baseUrl = $baseUrl[0];
		return $baseUrl;
	}
	
	/*
	* Check ajaxfilter Ajax enabled
	* 
	* @return boolean
	*/
	public function isAjaxAjaxfilterEnabled(){
		return $this->getConfig('price_ajaxfilter/ajax_conf/ajaxfilter');
	}
	
	
	public function getOnSlideCallbacks(){
		return $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/onSlide');	
	}
	
	/*
	* Get JS that brings the ajaxfilter in Action
	* 
	* @return JavaScript
	*/
	public function getAjaxfilterJs(){
		
		$baseUrl = $this->getCurrentUrlWithoutParams();
		$timeout = $this->getConfigTimeOut();
		$styles = $this->prepareCustomStyles();
		
		if($this->isAjaxAjaxfilterEnabled()){
			$ajaxCall = 'ajaxfilterAjax(url);';
		}else{
			$ajaxCall = 'window.location=url;';
		}
		
		if($this->isTextBoxEnabled()){
			$updateTextBoxPriceJs = '
							// Update TextBox Price
							$("#minPrice").val(newMinPrice); 
							$("#maxPrice").val(newMaxPrice);';
		}
		
		$html = '
			<script type="text/javascript">
				jQuery(function($) {
					var newMinPrice, newMaxPrice, url, temp;
					var categoryMinPrice = '.$this->_minPrice.';
					var categoryMaxPrice = '.$this->_maxPrice.';
					function isNumber(n){
					  return !isNaN(parseFloat(n)) && isFinite(n);
					}
					
					$(".priceTextBox").focus(function(){
						temp = $(this).val();	
					});
					
					$(".priceTextBox").keyup(function(){
						var value = $(this).val();
						if(!isNumber(value)){
							$(this).val(temp);	
						}
					});
					
					$(".priceTextBox").keypress(function(e){
						if(e.keyCode == 13){
							var value = $(this).val();
							if(value < categoryMinPrice || value > categoryMaxPrice){
								$(this).val(temp);	
							}
							url = getUrl($("#minPrice").val(), $("#maxPrice").val());
							'.$ajaxCall.'	
						}	
					});
					
					$(".priceTextBox").blur(function(){
						var value = $(this).val();
						if(value < categoryMinPrice || value > categoryMaxPrice){
							$(this).val(temp);	
						}
						
					});
					
					$(".go").click(function(){
						url = getUrl($("#minPrice").val(), $("#maxPrice").val());
						'.$ajaxCall.'	
					});
				var tooltip = function(sliderObj, ui){
                val1            = "<span class=\"slider_tooltip left\">"+ sliderObj.slider("values", 0) +"</span>";
                val2            = "<span class=\"slider_tooltip right\">"+ sliderObj.slider("values", 1) +"</span>";
                sliderObj.children(".ui-slider-handle").first().html(val1);
                sliderObj.children(".ui-slider-handle").last().html(val2);                  
            };

					$( "#ajaxfilter-range" ).slider({
						range: true,
						min: categoryMinPrice,
						max: categoryMaxPrice,
						values: [ '.$this->getCurrMinPrice().', '.$this->getCurrMaxPrice().' ],
						slide: function( event, ui ) {
							newMinPrice = ui.values[0];
							newMaxPrice = ui.values[1];
							tooltip($(this),ui); 
							$( "#amount" ).val( "'.$this->getCurrencySymbol().'" + newMinPrice + " - '.$this->getCurrencySymbol().'" + newMaxPrice );
							
							'.$updateTextBoxPriceJs.'
							
						},create:function(e,ui){
							tooltip($(this),ui);                    
						  }
						,stop: function( event, ui ) {
							
							// Current Min and Max Price
							var newMinPrice = ui.values[0];
							var newMaxPrice = ui.values[1];
							
							// Update Text Price
							$( "#amount" ).val( "'.$this->getCurrencySymbol().'"+newMinPrice+" - '.$this->getCurrencySymbol().'"+newMaxPrice );
							
							'.$updateTextBoxPriceJs.'
							
							url = getUrl(newMinPrice,newMaxPrice);
							if(newMinPrice != '.$this->getCurrMinPrice().' && newMaxPrice != '.$this->getCurrMaxPrice().'){
								clearTimeout(timer);
								//window.location= url;
								
							}else{
									timer = setTimeout(function(){
										'.$ajaxCall.'
									}, '.$timeout.');     
								}
						}
					});
					
					function getUrl(newMinPrice, newMaxPrice){
						return "'.$baseUrl.'"+"?min="+newMinPrice+"&max="+newMaxPrice+"'.$this->prepareParams().'";
					}
				});
			</script>
			
			'.$styles.'
		';	
		
		return $html;
	}
	
	
	/*
	*
	* Prepare custom ajaxfilter styles as per user configuration
	*
	* @return style/css
	*
	*/
	
	public function prepareCustomStyles(){
		$useImage = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/use_image');
		
		$handleHeight = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/handle_height');
		$handleWidth = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/handle_width');
		
		$ajaxfilterHeight = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/ajaxfilter_height');
		$ajaxfilterWidth = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/ajaxfilter_width');
		
		$amountStyle = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/amount_style');
		
		
		if($useImage){
			$handle = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/handle_image');
			$range = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/range_image');
			$ajaxfilter = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/background_image');	
			
			if($handle){$bgHandle = 'url('.$this->_imagePath.$handle.') no-repeat';}
			if($range){$bgRange = 'url('.$this->_imagePath.$range.') no-repeat';}
			if($ajaxfilter){$bgAjaxfilter = 'url('.$this->_imagePath.$ajaxfilter.') no-repeat';}
		}else{
			$bgHandle = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/handle_color');
			$borderHandle = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/handle_border_color');
			$bgRange = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/range_color');
			$bgAjaxfilter = $this->getConfig('price_ajaxfilter/price_ajaxfilter_conf/background_color');	
			
		}
		
		$html = '<style type="text/css">';	
			$html .= '.block-layered-nav .price-range-holder .ui-slider .ui-slider-handle{';
			if($borderHandle){$html .= 'border-color:#'.$borderHandle.';';}
			if($bgHandle){$html .= 'background:#'.$bgHandle.';';}
			$html .= 'width:'.$handleWidth.'px; height:'.$handleHeight.'px;}';
			
			$html .= '.block-layered-nav .price-range-holder .ui-slider.ui-slider-horizontal{';
			if($bgAjaxfilter){$html .= 'background:#'.$bgAjaxfilter.';';}
			$html .= ' width:'.$ajaxfilterWidth.'px; height:'.$ajaxfilterHeight.'px; border:none;}';
			
			$html .= '.block-layered-nav .price-range-holder .ui-slider .ui-slider-range{';
			if($bgRange){$html .= 'background:#'.$bgRange.';';}
			$html .= 'border:none;}';
			
			$html .= '#amount{'.$amountStyle.'}';	
		$html .= '</style>';		
		return $html;
	}
	
	
	/*
	* Get the Ajaxfilter config 
	*
	* @return object
	*/
	public function getConfig($key){
		return Mage::getStoreConfig($key);
	}
	
	
	/*
	* Set the Actual Min Price of the search and catalog collection
	*
	* @use category | search collection
	*/
	public function setMinPrice(){
		if( (isset($_GET['q']) && !isset($_GET['min'])) || !isset($_GET['q'])){
			
			if(Mage::getVersion() < '1.7.0.2'){
				$this->_productCollection->getSelect()->reset('order');
				$this->_productCollection->getSelect()->order('final_price','asc');
				$this->_minPrice = round($this->_productCollection->getFirstItem()->getFinalPrice());
			}else{
				$this->_minPrice = floor($this->_productCollection->getMinPrice());
			}

			$this->_searchSession->setMinPrice($this->_minPrice);		
		}else{
			$this->_minPrice = $this->_searchSession->getMinPrice();	
		}
		
	}
	
	/*
	* Set the Actual Max Price of the search and catalog collection
	*
	* @use category | search collection
	*/
	public function setMaxPrice(){
		if( (isset($_GET['q']) && !isset($_GET['max'])) || !isset($_GET['q'])){
			
			if(Mage::getVersion() < '1.7.0.2'){
				$this->_productCollection->getSelect()->reset('order');
				$this->_productCollection->getSelect()->order('final_price','asc');
				$this->_maxPrice = round($this->_productCollection->getLastItem()->getFinalPrice());
			}else{
				$this->_maxPrice = ceil($this->_productCollection->getMaxPrice());	
			}
			
			$this->_searchSession->setMaxPrice($this->_maxPrice);
		}else{
			$this->_maxPrice = $this->_searchSession->getMaxPrice();
		}
		
		
	}
	
	/*
	* Set the Product collection based on the page server to user 
	* Might be a category or search page
	*
	* @set /*
	* Set the Product collection based on the page server to user 
	* Might be a category or search page
	*
	* @set Mage_Catalogsearch_Model_Layer 
	* @set Mage_Catalog_Model_Layer    
	*/
	public function setProductCollection(){
		
		if($this->_currentCategory){
			$this->_productCollection = $this->_currentCategory
							->getProductCollection()
							->addAttributeToSelect('*')
                            ->setOrder('price','desc');
		}else{
			$this->_productCollection = Mage::getSingleton('catalogsearch/layer')->getProductCollection()	
							->addAttributeToSelect('*');
		}					
	}
	
	
	/*
	* Set Current Max and Min Prices choosed by the user
	*
	* @set price
	*/
	public function setCurrentPrices(){
		
		$this->_currMinPrice = $this->getRequest()->getParam('min');
		$this->_currMaxPrice = $this->getRequest()->getParam('max');
	}	
	
	/*
	* Set Current Max and Min Prices choosed by the user
	*
	* @set price
	*/
	public function baseToCurrent($srcPrice){
		$store = $this->getStore();
        return $store->convertPrice($srcPrice, false, false);
	}
	
	
	public function setInSession($var, $value){
		$set = "set".$var;
		Mage::getSingleton('catalog/session')->$set($value);	
	}
	
	public function getFromSession($var){
		$get = "get".$var;
		return Mage::getSingleton('catalog/session')->$get();	
	}
	
	/*
	* Retrive store object
	*
	* @return object
	*/
	public function getStore(){
		return Mage::app()->getStore();
	}
}
