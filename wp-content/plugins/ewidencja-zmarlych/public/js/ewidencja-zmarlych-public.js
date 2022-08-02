jQuery(document).ready(function( $ ) {
// handle links with @href started with '#' only
$(document).on('click', 'a[href^="#"]', function(e) {
    // target element id
    var id = $(this).attr('href');

    // target element
    var $id = $(id);
    if ($id.length === 0) {
        return;
    }

    // prevent standard hash navigation (avoid blinking in IE)
    e.preventDefault();

    // top position relative to the document
    var pos = $id.offset().top;

    // animated top scrolling
    $('body, html').animate({scrollTop: pos});
});
});

jQuery(function ($) {
    $('a.open-toggle').on('click', function(event){
		$('#zapytaj2.pokaz').removeClass('pokaz');
        $('#zapytaj.ukryj').addClass('pokaz');
		$('#zapytaj3.pokaz').removeClass('pokaz');
    });
});
jQuery(function ($) {
    $('a.open-toggle2').on('click', function(event){
		$('#zapytaj.pokaz').removeClass('pokaz');
        $('#zapytaj2.ukryj').addClass('pokaz');
		$('#zapytaj3.pokaz').removeClass('pokaz');
    });
});
jQuery(function ($) {
    $('a.open-toggle3').on('click', function(event){
		$('#zapytaj.pokaz').removeClass('pokaz');
        $('#zapytaj3.ukryj').addClass('pokaz');
		$('#zapytaj2.pokaz').removeClass('pokaz');
    });
});