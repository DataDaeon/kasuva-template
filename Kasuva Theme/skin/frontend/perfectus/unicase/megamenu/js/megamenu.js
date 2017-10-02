jQuery.noConflict();
(function($) {
    debug = false;
    /**
     * We overwrite the global mainNav function that is added by Magento for its own drop down menu.
     * @param menuId
     */
    mainNav = function(menuId) {
        // Magento gives us nav by default so make the nav an Id for jQuery.
        var menu = "#ucmgmenu, #sidebarnav";

        // Initialise the Mega Men.
        if(debug) {
            $(menu).megaMenu('debug', 2);
        }
        else {
            $(menu).megaMenu();
        }

    }
	
    /* Mega Menu Methods. */
    var hideTimer = null,
        showTimer = null,
        menuEnabled = false;
    methods = {

        // Initialise the mega menu
        init: function() {
            // We have the menu disabled when the page loads to prevent the drop down appearing
            // on a new page load when they've clicked a parent item and then not moved their mouse.
            $("body").mousemove(function() {
                menuEnabled = true;

                // Unbind for performance
                $("body").unbind("mousemove");
            });
			
			var navList = $('.pumenu-content .mobile-nav');
			var etOpener = '<span class="open-child">(open)</span>';
			navList.addClass('nav-mobile-menu');
			navList.find('li:has(ul)',this).each(function() {
				$(this).prepend(etOpener);
			});
			navList.find('.open-child').click(function(){
				if ($(this).parent().hasClass('over')) {
					$(this).parent().removeClass('over').find('> ul').slideUp(200);
				}else{
					$(this).parent().parent().find('> li.over').removeClass('over').find('> ul').slideUp(200);
					$(this).parent().addClass('over').find('> ul').slideDown(200);
				}
			});

			navList.on('click', 'li > a', function(e) {
				if($(this).attr('href') == '#') {
					e.preventDefault();
					$(this).parent().find('> .open-child').click();
				}
			});
			
			var eventtype = methods.mobilecheck() ? 'touchstart' : 'click';
			var pumenu_container = $('.pumenu-container');
			var bodyPuMenuClickFn = function(e) {
				if(!methods.hasPuMenuParentClass( e.target, 'pumenu-content')) {
					methods.resetPuMenuMobile();
					document.removeEventListener( eventtype, bodyPuMenuClickFn);
				}
			}
			
			$('.pumenu-toggle').bind('click', function() {
				var pumenu_effect = $(this).attr( 'data-effect' );
				if($('html').hasClass('pumenu-open')) {
					$('html').removeClass('pumenu-open');	  
				} else {
					$(pumenu_container).addClass(pumenu_effect);
					$('body').addClass(pumenu_effect);
					$('html').addClass('pumenu-open');	   
					setTimeout(function() {
						document.addEventListener( eventtype, bodyPuMenuClickFn);  
					}, 20); 
						
				}
				
			});
			$('.close-pumenu').click(function() {
				methods.resetPuMenuMobile();
				document.removeEventListener( eventtype, bodyPuMenuClickFn);
			});
			

            return this.each(function() {
                // This is our top level ul and we look for the anchors to bind
                // our show and hide events.
                $(this).find("li.level0 > a").hover(
                    function() {
                        methods.show($(this));
                    },
                    function() {
                        methods.hide($(this));
                    }
                );

                // We don't want the menu to hide when we're hovering over the drop down so
                // we clear the timeout on mouseover and trigger the hide on mouseout.
                $(this).find(".nav-dropdown").hover(
                    function() {
                        clearTimeout(hideTimer);
                    },
                    function() {
                        methods.hide($(this).prev("a"));
                    }
                );
            });
        },

        show: function(anchor) {

            if(menuEnabled) {
                // Clear the show timer. This stops the menu flickering when you hover over one
                // menu item and then straight onto the next without letting the previous menu appear.
                clearTimeout(showTimer);

                showTimer = setTimeout(function() {
                    // Select the menu columns to show.
                    var menuColumns = anchor.next(".nav-dropdown");

                    // Clear the timeout in case a hide had already been activated.
                    clearTimeout(hideTimer);

                    // Make sure the menu is not already been displayed
                    if(!menuColumns.hasClass('active')) {

                        // Hide any other menu items that may be displayed.
                        $(".nav-dropdown").hide();
                        $(".nav-dropdown").removeClass('active');

                        // Show our new menu
                        menuColumns.show();
                        menuColumns.addClass('active');
                    }
                },100);
            }
        },

        hide: function(anchor) {

            // Clear the show timer in case they hover off before the item was ever shown.
            clearTimeout(showTimer);

            hideTimer = setTimeout(function() {
                var menuColumns = anchor.next(".nav-dropdown");

                // Hide this menu item.
                menuColumns.hide();

                // remove the active class from the menu so it gets re-shown.
                menuColumns.removeClass('active');
            }, 150);
        },

        // Helps for styling.
        debug : function(index) {
            menuEnabled = true;
            methods.show($(this).find("a").eq(index));
        },
		hasPuMenuParentClass : function(e, classname){
			if(e === document) return false;
			if($(e).hasClass(classname)){
				return true;
			}
			return e.parentNode && methods.hasPuMenuParentClass(e.parentNode, classname);
		},
		mobilecheck : function(){
				var check = false;
				(function(a){if(/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
				return check;
		},
		resetPuMenuMobile : function(){
			$('html').removeClass('pumenu-open');
			$('body').removeClass('pumenu-block');
		}
		
    };

    // Mega menu jQuery plugin.
    $.fn.megaMenu = function(method) {
        // Check if the method exists on the plugin.
        if(methods[method]) {
            // Remove argument 1 which was the method name.
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if(typeof method === 'object' || !method) {
            //If no method was supplied then we initalise the menu.
            return methods.init.apply(this, arguments);
        }
        else {

            // undefined method so set the error
            $.error('Undefined method ' + method + ' in Mega Menu.');
        }

    }
}(jQuery));