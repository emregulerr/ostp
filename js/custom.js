// preloader
$(window).on('load',function () {
    $('.preloader').fadeOut(1000);
    $('input[name*="tel"]').inputmask("(999) 999-9999", {
        'removeMaskOnSubmit': true,
        'clearIncomplete': false
    });
    $('input[name*="mail"]').inputmask("email",{"clearIncomplete":true});
});

// collapse mobil nav on click
$('.navbar-nav>li>a').on('click', function(){ $('.navbar-collapse').collapse('hide'); });

new WOW().init();