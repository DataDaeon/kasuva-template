(function($) {
    "use strict";
	/*prototype bootstrap conflict code */
    var isBootstrapEvent = false;
	var isTouchableDevice = false;
	
    if (window.jQuery) {
        var all = jQuery('*');
        jQuery.each(['hide.bs.dropdown', 
            'hide.bs.collapse', 
            'hide.bs.modal', 
            'hide.bs.tooltip',
            'hide.bs.popover',
            'hide.bs.tab'], function(index, eventName) {
            all.on(eventName, function( event ) {
                isBootstrapEvent = true;
            });
        });
    }
    var originalHide = Element.hide;
    Element.addMethods({
        hide: function(element) {
            if(isBootstrapEvent) {
                isBootstrapEvent = false;
                return element;
            }
            return originalHide(element);
        }
    });
	
	//Check is touchable
	if('ontouchstart'in document.documentElement)
	isTouchableDevice=true;
		
	//Mobile responsive nav
	if($('.header-res-nav').length > 0 ){
		$('body').on('click', '.header-res-nav .dropdown-toggle', function(event) {
			var curthis = this;
			event.stopPropagation();
			if($(this).hasClass('main-top-toggle') && (!$(this).parents('.main-top-dropdown').hasClass('open'))){
				var triMnDrp = $('.header-res-nav .dropdown-toggle').parents('.main-top-dropdown');
				triMnDrp.removeClass('open');
				triMnDrp.find('.dropdown-main-menu').slideUp(400);
			}
			
			$(this).next('.dropdown-menu').slideToggle(100,function(){
				if($(this).css('display')=='block'){
					$(this).closest('.dropdown').addClass('open');
				}else{
					$(this).closest('.dropdown').removeClass('open');
				}
			});
		});
		$('.header-res-nav .dropdown-main-menu .close-dropdown').click(function(){
			$('.header-res-nav .dropdown-main-menu').slideUp(400);
		});
	}
	
	/*Header Search */
	$('.search-categories .dropdown-menu li> a').click(function(){
		var val=$(this).attr("data-val");
		var cattitle=$(this).attr("data-title");
		$(".search-categories").find('span.sel_cat').html(cattitle);
		$(".search-area").find('.hid_cat_val').val(val);
	});
	
	//sticky-nav
	if($('.StickyNav').length > 0 && $(".header-nav").length > 0 && $(window).width() > 990){
		var scrolled = false;
		var headernav_offset=$(".header-nav").offset().top;
		$(window).scroll(function(){
				if(headernav_offset < $(window).scrollTop() && !scrolled){
					if(!$('.header-wrapper .menu-wrapper .sticky-logo').length && !$('.header-wrapper .menu-wrapper .sticky-minicart').length){
						$('.header-wrapper').addClass("sticky-nav");
						var header_logo = $('<div>').append($('.header-wrapper .site-branding > .logo').clone()).html();
						$('.header-wrapper .menu-wrapper').prepend('<div class="sticky-logo">'+header_logo+'</div>');
						var minicart = $('.main-header-content #minicart-header').html();
						$('.header-wrapper .menu-wrapper').append('<div class="sticky-minicart">'+minicart+'</div>');
						scrolled = true;
					}
				}
				if(headernav_offset>=$(window).scrollTop() && scrolled){
					$('.header-wrapper').removeClass("sticky-nav");
					$('.header-wrapper .menu-wrapper .sticky-minicart').remove();
					$('.header-wrapper .menu-wrapper .sticky-logo').remove();
					scrolled = false;

				}
		});
	}
	
	/*grid mode*/
	$(document).ready(function(){
		pu_prod_list(checkBootstrapMode());
		footerCollapse();
	});
	$(window).resize(function(){
		pu_prod_list(checkBootstrapMode());
	});
	
	$(document).ready(function () {
		//table-responsive
		dataTableResponsive();
		//owlproduct slider
		$('.home-owl-carousel').each(function(){
			var owl = $(this);
			var itemPerLine = owl.data('item');
			var itemLg = owl.data('lg');
			var itemMd = owl.data('md');
			var itemSm = owl.data('sm');
			var itemXs = owl.data('xs');
			var sType = owl.data('stype');
			var sType = owl.data('stype');
			if(itemPerLine==''){
				var sgItem = true;
			}else{
				var sgItem = false;
			}
			if(!itemPerLine){
				itemPerLine = 4;
			}
			
			var itemLg = (itemLg > 0) ? itemLg : 4;
			var itemMd = (itemMd > 0) ? itemMd : 3;
			var itemSm = (itemSm > 0) ? itemSm : 2;
			var itemXs = (itemXs > 0) ? itemXs : 1;
			
			/*
			//check home version
			if($('.home-2columns-left, .home-2columns-right').length > 0){
				var itemsDesktop = 4;
				if(sType=='micro'){
					itemsDesktop = 2;
				}else if(sType=='slider'){
					if(itemPerLine == 4){
						itemsDesktop = 3;
					}	
				}
			}else{
				itemsDesktop = itemPerLine;
			}

			//slider type
			if(sType=='micro'){
				itemsDesktopSmall = itemPerLine-1;
			}else if(sType=='slider'){
				if(itemPerLine == 2){
					itemsDesktopSmall = itemPerLine+1;
				}else{
					itemsDesktopSmall = itemPerLine-1;
				}
				
			}*/
			owl.owlCarousel({
				singleItem : sgItem,
				lazyLoad : false,
				items : itemPerLine,
				itemsCustom : [
					[1199, itemPerLine],
					[992, itemLg],
					[760, itemMd],
					[500, itemSm],
					[360, itemXs],
					[0, 1],
				],
				navigation : true,
				pagination : false,
			});
		});
		
	/*ui-pattern*/
    $('.toggle-content').each(function () {
        var wrapper = jQuery(this);

        var hasTabs = wrapper.hasClass('tabs');
        var hasAccordion = wrapper.hasClass('accordion');
        var startOpen = wrapper.hasClass('open');

        var dl = wrapper.children('dl:first');
        var dts = dl.children('dt');
        var panes = dl.children('dd');
        var groups = new Array(dts, panes);

        //Create a ul for tabs if necessary.
        if (hasTabs) {
            var ul = jQuery('<ul id="product-tabs" class="toggle-tabs nav nav-tabs nav-tab-cell"></ul>');
            dts.each(function () {
                var dt = jQuery(this);
                var li = jQuery('<li></li>');
                li.html(dt.html());
                ul.append(li);
            });
            ul.insertBefore(dl);
            var lis = ul.children();
            groups.push(lis);
        }

        //Add "last" classes.
        var i;
        for (i = 0; i < groups.length; i++) {
            groups[i].filter(':last').addClass('last');
        }

        function toggleClasses(clickedItem, group) {
            var index = group.index(clickedItem);
            var i;
            for (i = 0; i < groups.length; i++) {
                groups[i].removeClass('active');
                groups[i].eq(index).addClass('active');
            }
        }

        //Toggle on tab (dt) click.
        dts.on('click', function (e) {
            //They clicked the active dt to close it. Restore the wrapper to unclicked state.
            if (jQuery(this).hasClass('active') && wrapper.hasClass('accordion-open')) {
                wrapper.removeClass('accordion-open');
            } else {
                //They're clicking something new. Reflect the explicit user interaction.
                wrapper.addClass('accordion-open');
            }
            toggleClasses(jQuery(this), dts);
        });

        //Toggle on tab (li) click.
        if (hasTabs) {
            lis.on('click', function (e) {
                toggleClasses(jQuery(this), lis);
            });
            //Open the first tab.
            lis.eq(0).trigger('click');
        }

        //Open the first accordion if desired.
        if (startOpen) {
            dts.eq(0).trigger('click');
        }

    });
	$(".blog-slider").owlCarousel({
		items : 3,
		itemsDesktopSmall :[979,2],
		itemsDesktop : [1199,2],
		navigation : true,
		lazyLoad : true,
		slideSpeed : 300,
		pagination: false,
		navigationText: ["", ""]
	});
	$(".sidebar-carousel").owlCarousel({
		items : 1,
		itemsDesktop : [1199,1],
		itemsDesktopSmall :[979,2],
		itemsTablet: [768, 2],
		itemsTabletSmall: [560, 2],
		navigation : true,
		lazyLoad : true,
		slideSpeed : 300,
		pagination: false,
		paginationSpeed : 400,
		navigationText: ["", ""]
	});
	if($('.advertisement-slider').length){
		$(".advertisement-slider").owlCarousel({
			items : 1,
			itemsDesktopSmall :[979,2],
			itemsDesktop : [1199,1],
			navigation : true,
			slideSpeed : 300,
			pagination: true,
			paginationSpeed : 400,
			navigationText: ["", ""]
		});
	}
	/*lazy load*/
	echo.init({
        offset: 100,
        throttle: 1,
        unload: false
    });
	/* Product thumbnail gallery */
	$('#product-image-thumbs').owlCarousel({
        items: 4,
        pagination: true,
		navigation : true,
        rewindNav: true,
		itemsCustom : [[680, 4],[768, 4],[900, 4],[1024, 4],[1400, 4]],
    });
	/* quentity input */
	$('.quant-input .plus').click(function() {
		var val = $(this).parent().next().val();
		val = parseInt(val) + 1;
		$(this).parent().next().val(val);
	});
	$('.quant-input .minus').click(function() {
		var val = $(this).parent().next().val();
		if (val > 1) {
			val = parseInt(val) - 1;
			$(this).parent().next().val(val);
		}
	});
	$('.quant-input .plus, .quant-input .minus').click(function() {
		$(this).parents(".product-cart-actions").find('[name="update_cart_action"]').show(200);
	});
	//wow
	var wow = new WOW({
		boxClass:     'wow',      // default
        animateClass: 'animated', // default
        mobile:       false,       // default
        live:         true        // defaul
	})
	wow.init();
	//new WOW().init();
	$(document).ready(function(){

		//Check to see if the window is top if not then display button
		$(window).scroll(function(){
			if ($(this).scrollTop() > 100) {
				$('.scrollToTop').fadeIn(400);
			} else {
				$('.scrollToTop').fadeOut(400);
			}
		});
		
		//Click event to scroll to top
		$('.scrollToTop').click(function(){
			$('html, body').animate({scrollTop : 0},800);
			return false;
		});
		
	});
});
$("[data-toggle='tooltip']").tooltip(); 
//load lazyload
$(window).load(function(){
	lazyLoadImg();
});

})(jQuery);

function resProdGallery(slider){
	var w=jQuery(window).width();
	var opt={items: 1,pagination: true,navigation : true,rewindNav: false,responsive: true,itemsTablet: [768,2],itemsMobile : [480,1]};
	if(w < 769){
		if(slider.find(".owl-wrapper").length==0){
			slider.owlCarousel(opt);
		}
	}else{		
		if(slider.find(".owl-wrapper").length){
			slider.data('owlCarousel').destroy();
		}
	}
}
function checkBootstrapMode(){
	if (jQuery(window).width() < 480){ return 'xxs';}
	else if(jQuery(window).width() >= 480 && jQuery(window).width() < 769) { return 'xs'; }
	else if(jQuery(window).width() >= 769 && jQuery(window).width() < 992) { return 'sm'; }
	else if (jQuery(window).width() >= 992 && jQuery(window).width() < 1200) { return 'md'; }
	else if (jQuery(window).width() >= 1200 && jQuery(window).width() < 1770) { return 'lg'; }
	else { return 'xl'; }
}
function pu_prod_list(size){
	var colsGrid=jQuery(".products-grid.products-grid-list");
	if(size=='xl'){ size='lg'; }
	if(colsGrid.length > 0){
		colsGrid.each(function(index){
			var parthis=jQuery(this);
			var curdata= parthis.attr("data-"+size);
			
			if(curdata){
				parthis.children('.clearfix').remove();
				var divs=parthis.children("div.item");
				divs.each(function(index){
					var chithis=jQuery(this);
					if((index%curdata==0) && index!=0){
						chithis.before("<div class='clearfix'></div>");
					}
				});
			}
		});
	}
}
function is_touch_device() {
 return (('ontouchstart' in window)
      || (navigator.MaxTouchPoints > 0)
      || (navigator.msMaxTouchPoints > 0));
}
// Mobile footer collapse
function footerCollapse() {
	jQuery('.mobile-collapse__title').on('click', function(e) {
		e.preventDefault;
		jQuery(this).parent('.mobile-collapse').toggleClass('open');
	});
};
//data table
function dataTableResponsive(){
	if(jQuery('table.data-table').length > 0 ){
		jQuery('table.data-table').each(function(){
			jQuery(this).wrap('<div class="tbl-responsive"></div>');
		});
	}
}
//lazyload direct
function lazyLoadImg(){
	if(jQuery('.lazyOwl').length > 0 ){
		jQuery('.lazyOwl').each(function(){
			var datasrc = jQuery(this).attr("data-src");
			if(datasrc!=''){
				jQuery(this).attr('src', datasrc);
				jQuery(this).removeAttr('data-src');
			}
		});
	}
}