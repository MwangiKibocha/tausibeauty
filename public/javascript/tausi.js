$('document').ready(function() {
        $('#carousel').slick()
        $('label').click(function() {
            $(this).css("color", "rgb(236, 27, 97)")
        })
    })
    /*$(document).ready(function() {
        $('#carousel').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });*/