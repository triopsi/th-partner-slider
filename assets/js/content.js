;(function($){
    $(document).ready(function (){ 
        $(".thpp-panel").lightSlider({
            item:4,
            loop:true,
            slideMove:2,
            auto:true,
            pauseOnHover: true,
            easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
            speed:600,
            autoWidth:true,
            controls: false,
            pager: false,
            onSliderLoad: function() {
                $('#autoWidth').removeClass('cS-hidden');
            },
            responsive : [
                {
                    breakpoint:800,
                    settings: {
                        item:3,
                        slideMove:1,
                        slideMargin:6,
                      }
                },
                {
                    breakpoint:480,
                    settings: {
                        item:2,
                        slideMove:1
                      }
                }
            ]
        });  
    });
})(jQuery);