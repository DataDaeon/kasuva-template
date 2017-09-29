var bp = {
    xsmall: 479,
    small: 599,
    medium: 770,
    large: 979,
    xlarge: 1199
};

// Use jQuery(document).ready() because Magento executes Prototype inline
jQuery(document).ready(function () {

        //initialize pointer abstraction manager
    //PointerManager.init();

    /* Wishlist Toggle Class */
    jQuery(".change").click(function (e) {
        jQuery( this ).toggleClass('active');
        e.stopPropagation();
    });

    jQuery(document).click(function (e) {
        if (! jQuery(e.target).hasClass('.change')) jQuery(".change").removeClass('active');
    });
   
    /* Generic, efficient window resize handler */
    var resizeTimer;
    jQuery(window).resize(function (e) {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            jQuery(window).trigger('delayed-resize', e);
        }, 250);
    });
});
var ProductMediaManager = {
    IMAGE_ZOOM_THRESHOLD: 20,
    imageWrapper: null,
    destroyZoom: function() {
        jQuery('.zoomContainer').remove();
        jQuery('.product-image-gallery').removeData('elevateZoom');
    },
    createZoom: function(image) {
        ProductMediaManager.destroyZoom();
        if(image.length <= 0) { //no image found
            return;
        }
        if(image[0].naturalWidth && image[0].naturalHeight) {
            var widthDiff = image[0].naturalWidth - image.width() - ProductMediaManager.IMAGE_ZOOM_THRESHOLD;
            var heightDiff = image[0].naturalHeight - image.height() - ProductMediaManager.IMAGE_ZOOM_THRESHOLD;
            if(widthDiff < 0 && heightDiff < 0) {
                image.parents('.product-image').removeClass('zoom-available');
                return;
            } else {
                image.parents('.product-image').addClass('zoom-available');
            }
        }
        image.elevateZoom(elevateZoomDATA);
		if(flagElevateLightBox){
			jQuery(".product-image-gallery .gallery-image").bind("click", function(e) {  
				var ez = jQuery('.product-image-gallery .gallery-image').data('elevateZoom');	
					jQuery.fancybox(ez.getGalleryList());
				return false;
			});
		}
    },
    swapImage: function(targetImage) {
        targetImage = jQuery(targetImage);
        targetImage.addClass('gallery-image');
        ProductMediaManager.destroyZoom();
        var imageGallery = jQuery('.product-image-gallery');
        if(targetImage[0].complete) {
            imageGallery.find('.gallery-image').removeClass('visible');
            imageGallery.append(targetImage);
            targetImage.addClass('visible');
            ProductMediaManager.createZoom(targetImage);

        } else { //need to wait for image to load
            imageGallery.addClass('loading');
            imageGallery.append(targetImage);
            imagesLoaded(targetImage, function() {
                imageGallery.removeClass('loading');
                imageGallery.find('.gallery-image').removeClass('visible');
                targetImage.addClass('visible');
                ProductMediaManager.createZoom(targetImage);
            });
        }
    },
    wireThumbnails: function() {
    },

    initZoom: function() {
        ProductMediaManager.createZoom(jQuery(".gallery-image.visible")); //set zoom on first image
    },
    init: function() {
        ProductMediaManager.imageWrapper = jQuery('.product-img-box');
        jQuery(window).on('delayed-resize', function(e, resizeEvent) {
            ProductMediaManager.initZoom();
        });
        ProductMediaManager.initZoom();
        ProductMediaManager.wireThumbnails();
        jQuery(document).trigger('product-media-loaded', ProductMediaManager);
    }
};
jQuery(document).ready(function() {
	ProductMediaManager.init();
});
