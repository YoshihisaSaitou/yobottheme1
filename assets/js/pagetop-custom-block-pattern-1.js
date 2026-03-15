jQuery(function () {
    runPagetopGlobalButton();
    
    jQuery(window).scroll(function () {
        runPagetopGlobalButton();
    });

    jQuery('.pagetop-custom-block-pattern-1').on('click', function() {
        jQuery('body,html').animate({scrollTop: 0});
    });
});

function runPagetopGlobalButton() {
    const scrollTop = jQuery(this).scrollTop();
    if(scrollTop > 0){
        jQuery('.pagetop-custom-block-pattern-1').fadeIn('slow');
    }else if(scrollTop == 0){
        jQuery('.pagetop-custom-block-pattern-1').css('display', 'none');
    }
}