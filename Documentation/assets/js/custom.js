jQuery(function($){
    $.fn.extend({
        scrollToMe: function(){
            if($(this).length){
                var top = $(this).offset().top - 0;
                $('html,body').animate({scrollTop: top}, 300);
            }
        },
        scrollToJustMe: function(){
            if($(this).length){
                var top = jQuery(this).offset().top;
                $('html,body').animate({scrollTop: top}, 300);
            }
        }
    });
    
    $(".bs-docs-sidebar a").not('.toggle').off("click").on("click", function(){
        var url = $(this).attr("href");
        if(url.indexOf("#") > -1) {
            $(url).scrollToMe();
            return false;
        }
    });
});