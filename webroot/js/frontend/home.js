jQuery(document).ready(function() {
    "use strict";

    var revapi;
    if ( $("#rev_slider").revolution == undefined ) {
        revslider_showDoubleJqueryError("#rev_slider");
    } else {
        revapi = $("#rev_slider").show().revolution({
            sliderType: "standard",
            jsFileLocation: "assets/js/",
            sliderLayout: "fullscreen",
            fullScreenAutoWidth: "on",
            dottedOverlay:"none",
            delay: 15000,
            navigation: {
                mouseScrollNavigation: "off",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on"
                },
                arrows: {
                    style: "zeus",
                    enable: true,
                    hide_onmobile: false,
                    hide_onleave: false,
                    hide_under: 778,
                    tmp: '<div class="tp-title-wrap"> <div class="tp-arr-imgholder"></div> </div>',
                    left: {
                        h_align: "left",
                        v_align: "center",
                        h_offset: 20,
                        v_offset: 0
                    },
                    right: {
                        h_align: "right",
                        v_align: "center",
                        h_offset: 20,
                        v_offset: 0
                    }
                },
                bullets: {
                    enable: true,
                    hide_onmobile: false,
                    style: "zeus",
                    hide_onleave: false,
                    direction: "horizontal",
                    h_align: "left",
                    v_align: "bottom",
                    h_offset: 20,
                    v_offset: 20,
                    space: 8,
                    tmp: ''
                }
            },
            responsiveLevels: [1200,992,768,480],
            gridwidth: [1140,970,750,480],
            gridheight: [520,450,380,320],
            lazyType: "smart",
            spinner: "spinner2",
            parallax: {
                type: "mouse",
                origo: "slidercenter",
                speed: 2000,
                levels: [2,3,4,5,6,7,12,16,10,50],
                disable_onmobile: "on"
            },
            debugMode: false
        });
    }
});