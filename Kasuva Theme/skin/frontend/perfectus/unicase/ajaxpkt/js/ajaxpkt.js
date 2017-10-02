jQuery(document).ready(function(){
	jQuery('.ajaxpkt-qckview').fancybox(
		{
			hideOnContentClick : true,
			width: 1024,
			padding:20,
			autoDimensions: true,
			type : 'iframe',
			showTitle: false,
			scrolling: 'no',
			afterLoad: function(){ //Resize the iframe to correct size
				jQuery(".product").removeClass("ajaxpkt-qckloader");
				jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
					jQuery('#fancybox-content').height($(this).contents().find('body').height()+30);
					jQuery.fancybox.resize();
				});
			},
			'helpers': {
				overlay: {
					showEarly : false,
					locked: false
				}
			}
		   
		}
	);
});
function closeAjaxpktPopup(){
	jQuery(".ajaxpkt-block").fadeOut(300);
}
function showOptions(e,id){
	jQuery(e).parents(".product").addClass("ajaxpkt-qckloader");
	jQuery('#ajaxpkt'+id).trigger('click');
}
function setAjaxPktData(data){
	var timer = null;
	if (timer) {
		clearTimeout(timer); //cancel the previous timer.
		timer = null;
	}
	jQuery('.ajaxpkt-block').fadeIn(200);
	jQuery('.ajaxpkt-block .inner-content').html(data.message);
	setTimeout(function(){ closeAjaxpktPopup; }, 100);
}
function setAjaxData(data,iframe){
	if(data.status == 'ERROR'){
		setAjaxPktData(data);
	}else{
		if(jQuery('header .top-link-left') && (data.toplink)){
			jQuery('header .top-link-left').replaceWith(data.toplink);
		}
		if(jQuery('.block-cart')){
			jQuery('.block-cart').replaceWith(data.sidebar);
		}
		if(jQuery('.miniCartBlock')){
			jQuery('.miniCartBlock').replaceWith(data.minicart);
		}
		setAjaxPktData(data);
	}
}
function setLocationAjax(e,url,id){
	url += 'isAjax/1';
	url = url.replace("checkout/cart","ajaxpkt/index");
	jQuery(e).parents(".product").addClass("ajaxpkt-loader");
	try {
		jQuery.ajax( {
			url : url,
			dataType : 'json',
			success : function(data) {
				jQuery(e).parents(".product").removeClass("ajaxpkt-loader");
				setAjaxData(data,false);         
			}
		});
	} catch (e) {
	}
}
function setAjaxpktCartDelete(e,url){
	url = url.replace("checkout/cart/delete","ajaxpkt/index/delete");
	url += 'isAjax/1/';
	jQuery(e).parents(".minicart-content").addClass("product ajaxpkt-loader");
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery(e).parents(".minicart-content").removeClass("product ajaxpkt-loader");
			setAjaxData(data);
		}
	});
}
function ajaxCompare(e,url,id){
	url = url.replace("catalog/product_compare/add","ajaxpkt/index/compare");
	url += 'isAjax/1/';
	jQuery(e).parents(".product").addClass("ajaxpkt-loader");
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery(e).parents(".product").removeClass("ajaxpkt-loader");
			if(data.status == 'ERROR'){
				setAjaxPktData(data);
			}else{
				setAjaxPktData(data);
				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }
				if(jQuery('.topbar-compare').length){
					jQuery('.topbar-compare').replaceWith(data.toplink);
				}
			}
		}
	});
}
function ajaxCRemove(e,url,id){
	url = url.replace("catalog/product_compare/remove","ajaxpkt/index/comdelete");
	url += 'isAjax/1/';
	jQuery(e).parents(".compare-content").addClass("product ajaxpkt-loader");
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery(e).parents(".compare-content").removeClass("product ajaxpkt-loader");
			if(data.status == 'ERROR'){
				setAjaxPktData(data);
			}else{
				setAjaxPktData(data);
				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }else{
                    if(jQuery('.col-right').length){
                    	jQuery('.col-right').prepend(data.sidebar);
                    }
                }
				if(jQuery('.topbar-compare').length){
					jQuery('.topbar-compare').replaceWith(data.toplink);
				}
			}
		}
	});
}
function ajaxClearRemove(e,url){
	url = url.replace("catalog/product_compare/clear","ajaxpkt/index/comclear");
	url += 'isAjax/1/';
	jQuery(e).parents(".compare-content").addClass("product ajaxpkt-loader");
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery(e).parents(".compare-content").removeClass("product ajaxpkt-loader");
			if(data.status == 'ERROR'){
				setAjaxPktData(data);
			}else{
				setAjaxPktData(data);
				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }else{
                    if(jQuery('.col-right').length){
                    	jQuery('.col-right').prepend(data.sidebar);
                    }
                }
				if(jQuery('.topbar-compare').length){
					jQuery('.topbar-compare').replaceWith(data.toplink);
				}
			}
		}
	});
}
function ajaxWishlist(e,url,id){
	url = url.replace("wishlist/index/add","ajaxpkt/index/addwish");
	url += 'isAjax/1/';
	jQuery(e).parents(".product").addClass("ajaxpkt-loader");
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery(e).parents(".product").removeClass("ajaxpkt-loader");
			if(data.status == 'ERROR'){
				setAjaxData(data);
			}else{
				setAjaxData(data);
				if(jQuery('.block-wishlist').length){
                    jQuery('.block-wishlist').replaceWith(data.sidebar);
                }
			}
		}
	});
}
function ajaxPktQuickview(e,id){
	jQuery(e).parents(".product").addClass("ajaxpkt-qckloader");
	jQuery('#ajaxPktQck'+id).trigger('click');
}
