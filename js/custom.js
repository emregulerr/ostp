// preloader
$(window).on('load',function () {
    $('.preloader').fadeOut(1000); // set duration in brackets
    $('input[name*="tel"]').inputmask("(999) 999-9999", {
        'removeMaskOnSubmit': true,
        'clearIncomplete': false
    });
});

// collapse mobil nav on click
$('.navbar-nav>li>a').on('click', function(){ $('.navbar-collapse').collapse('hide'); });

new WOW().init();