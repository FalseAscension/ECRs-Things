jQuery(document).ready(function($) {

    $('.slideshow').each(function() {
        var $slideshow = $(this);
    
        var settings = {
            auto: true,
            speed: 500,
            timeout: 5000,
            pager: false,
            nav: false,
            random: false,
            pause: false,
            pauseControls: false,
            prevText: '<',
            nextText: '>',

            navContainer: '.slideshow__navigation'
        };

        $.each($slideshow.data(), (k,v) => { // user override settings saved in data- attributes
            settings[k] = v;
        });

        $slideshow.responsiveSlides(settings);
    });
});
