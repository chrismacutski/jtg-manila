 AOS.init({
 	duration: 800,
 	easing: 'slide'
 });

(function($) {

	"use strict";

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};


	// $(window).stellar({
	// 	responsive: true,
	// 	parallaxBackgrounds: true,
	// 	parallaxElements: true,
	// 	horizontalScrolling: false,
	// 	hideDistantElements: false,
	// 	scrollProperty: 'scroll'
	//   });


	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() {
			if($('#jtg-loader').length > 0) {
				$('#jtg-loader').removeClass('show');
			}
		}, 10);
	};
	loader();

	// Scrollax
   $.Scrollax();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  // console.log('show');
	});

	// scroll
	// var scrollWindow = function() {
	// 	$(window).scroll(function(){
	// 		var $w = $(this),
	// 				st = $w.scrollTop(),
	// 				navbar = $('.jtg_navbar'),
	// 				sd = $('.js-scroll-wrap');
    //
	// 		if (st > 150) {
	// 			if ( !navbar.hasClass('scrolled') ) {
	// 				navbar.addClass('scrolled');
	// 			}
	// 		}
	// 		if (st < 150) {
	// 			if ( navbar.hasClass('scrolled') ) {
	// 				navbar.removeClass('scrolled sleep');
	// 			}
	// 		}
	// 		if ( st > 350 ) {
	// 			if ( !navbar.hasClass('awake') ) {
	// 				navbar.addClass('awake');
	// 			}
    //
	// 			if(sd.length > 0) {
	// 				sd.addClass('sleep');
	// 			}
	// 		}
	// 		if ( st < 350 ) {
	// 			if ( navbar.hasClass('awake') ) {
	// 				navbar.removeClass('awake');
	// 				navbar.addClass('sleep');
     //                console.log('test5');
     //            }
	// 			if(sd.length > 0) {
	// 				sd.removeClass('sleep');
     //                console.log('test6');
     //            }
	// 		}
	// 	});
	// };
	// scrollWindow();

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
			BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
			iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
			Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
			Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
			any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	var contentWayPoint = function() {
		var i = 0;
		$('.jtg-animate').waypoint( function( direction ) {
			if( direction === 'down' && !$(this.element).hasClass('jtg-animated') ) {

				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){
					$('body .jtg-animate, .item-animate').each(function(k){
						var el = $(this);
                        setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn jtg-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft jtg-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight jtg-animated');
							} else {
								el.addClass('fadeInUp jtg-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});

				}, 100);

			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// navigation
	var OnePageNav = function() {
		$(".smoothscroll[href^='#'], #jtg-nav ul li a[href^='#']").on('click', function(e) {
		 	e.preventDefault();

		 	var hash = this.hash,
		 			navToggler = $('.navbar-toggler');
		 	$('html, body').animate({
				scrollTop: $(hash).offset().top
			  }, 700, 'easeInOutExpo', function(){
				window.location.hash = hash;
			  });


		  if ( navToggler.is(':visible') ) {
		  	navToggler.click();
		  }
		});
		$('body').on('activate.bs.scrollspy', function () {
		  // console.log('nice');
		})
	};
	OnePageNav();

})(jQuery);

