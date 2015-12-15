jQuery(document).ready(function(){

    jQuery(document).on('click','#wtd_gallery_nav a',function(event){
        event.preventDefault();
        var src = jQuery(this).attr('data-img');
        jQuery('#wtd_gallery_big img').attr('src',src);
        jQuery('#wtd_gallery_nav a').removeClass('current_image');
        jQuery(this).addClass('current_image');
    });

    jQuery(document).on('click','#wtd_gallery_next',function(event){
        event.preventDefault();
        var current_image = jQuery('#wtd_gallery_nav a.current_image');
        current_image.next('#wtd_gallery_nav a').click();
    });
    jQuery(document).on('click','#wtd_gallery_prev',function(event){
        event.preventDefault();
        var current_image = jQuery('#wtd_gallery_nav a.current_image');
        current_image.prev('#wtd_gallery_nav a').click();
    });

});
