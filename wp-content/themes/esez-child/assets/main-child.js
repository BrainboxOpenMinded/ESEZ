/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

jQuery(document).ready(function( $ ) {

$("input#keyword").keyup(function() {
    if ($(this).val().length > 2) {
      $("#datafetch").show();
    } else {
      $("#datafetch").hide();
    }
  });
});
// jQuery(document).ready(function( $ ) {
// 	$(document).ready(function () {
// 		$('#datatablesWTrakcie').DataTable({
// 			paging: false,
// 			responsive: true,
// 			search: true,
// 		});
// 	});
// });

/* Menu z roch */
(function( $ ) {
	var header, menuToggle, siteNavContain;

	header			= $( 'nav' );
	menuToggle		= header.find( '.navbar__icon' );
	siteNavContain	= header.find( '.navbar__links' );

	(function() {

		if ( ! menuToggle.length ) {
			return;
		}

		menuToggle.attr( 'aria-expanded', 'false' );

		menuToggle.on( 'click', function() {
			
			siteNavContain.toggleClass( 'toggled-on' );
			menuToggle.toggleClass( 'fa-bars' );
			menuToggle.toggleClass( 'fa-times' );
			$("body").toggleClass('no-scroll');
						
			$( this ).attr( 'aria-expanded', siteNavContain.hasClass( 'toggled-on' ) );
			
		});
	})();

	(function() {

		toTop = $( '#toTop' );

		$( window ).on('scroll', function() {
			if ( $( window ).scrollTop() > 250 ) {
				toTop.show();
			} else {
				toTop.hide();
			}
		});

		toTop.off( 'click' ).on( 'click', function() {
			$( 'html, body' ).animate({
				scrollTop: 0
			}, 1000 );
		});
	})();

})( jQuery );

jQuery('.menu-item-has-children > a').on('click', function(e) {
	jQuery(this).next('.sub-menu').toggleClass('pokaz');
	e.preventDefault();
  });

