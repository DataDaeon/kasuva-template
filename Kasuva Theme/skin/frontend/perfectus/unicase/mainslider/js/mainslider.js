jQuery(document).ready(function () {
//mainslider
    var dragging = true;
    var MNSlider=jQuery("#main-slider");
	if(typeof MNSliderOptions!=='undefined'){
		MNSliderOptions.startDragging= function() {dragging = true;}
		MNSliderOptions.afterInit=function(e){
			if(MNSlider.hasClass('autoHeight')){
				MNSlideInit(e);
				MNSliderInit(MNSlider.find('.owl-item.active'));
			}
			MNSlideHandler(MNSlider.find('.owl-item.active .animate'),'add');
		}
		MNSliderOptions.afterMove=function(e){
			MNSlideHandler(MNSlider.find('.owl-item .animate'),'remove');
			if(MNSlider.hasClass('autoHeight')){ 
				MNSlideInit(e); 
			}
			MNSlideHandler(MNSlider.find('.owl-item.active .animate'),'add');
		}
		//MNSliderOptions.beforeMove=function(e){MNSlideHandler(MNSlider.find('.owl-item.active .animate'),'remove');}
		MNSlider.owlCarousel(MNSliderOptions);
	}
});

function MNSliderInit(sld){
	sld.each(function(){
		var curnode = jQuery(this);
			jQuery("#main-slider").find('.owl-wrapper-outer').height(curnode.find('.caption').height()+100);
	});
}
function MNSlideInit(e){
	e.children().each(function(){
		var curnode = jQuery(this);
		curnode.find('.caption-main-content').height(curnode.find('.caption').height()+100);
	});
}
function MNSlideHandler(sld,action){
	sld.each(function(){
		var delay=jQuery(this).attr("data-delay");
		var duration=jQuery(this).attr("data-duration");
		var iteration=jQuery(this).attr("data-iteration");
		//var curnode = jQuery(this).parents('.owl-item');
		//curnode.find('.caption-main-content').height(curnode.find('.caption').height());
		if(action=='add'){
			jQuery(this).addClass(jQuery(this).attr("data-animation")+" animated");
			if(delay){jQuery(this).css({"animation-delay":delay})}
			if(duration){jQuery(this).css({"animation-duration":duration})}
			if(iteration){jQuery(this).css({"animation-iteration":iteration})}
		}else if(action=='remove'){
			jQuery(this).removeClass(jQuery(this).attr("data-animation")+" animated");
			if(delay){jQuery(this).css({"animation-delay":""})}
			if(duration){jQuery(this).css({"animation-duration":""})}
			if(iteration){jQuery(this).css({"animation-iteration":""})}
		}
	});
}