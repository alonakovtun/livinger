/* ==============================
 * Preloader
 * ============================== */

jQuery(window).on('load', function(){
	jQuery('#preloader').fadeOut(100);
});


/* ==============================
 * Logo
 * ============================== */

/*
 * Tagline Animation
 */

jQuery(document).ready(function(){
	var cntr1 = 0,
		cntr2 = 0;

	animLogo( jQuery('#aside-logo-tagline'), cntr1 );
	animLogo( jQuery('#header-logo-tagline'), cntr2 );

	function animLogo( bTaglineContainer, i ){
		var esTaglineUnits = jQuery('.tagline_unit', bTaglineContainer),
			esTaglineUnitsLength = esTaglineUnits.length;
			i = esTaglineUnitsLength+1;

		setInterval(function(){
			var prvsTaglineUnit = jQuery('.tagline_unit.active', bTaglineContainer);

			prvsTaglineUnit.removeClass('active');
			prvsTaglineUnit.addClass('disable');


			setTimeout(function(){
				var crntTaglineUnit = jQuery( esTaglineUnits.get( i%esTaglineUnitsLength ) );
				crntTaglineUnit.removeClass('disable');
				crntTaglineUnit.addClass('active')

				i++;
			}, 1500);
		}, 6000)
	}

});



/* ===============================
 * SLIDE MENU
 * =============================== */

jQuery(document).ready(function(){
	var btnOpen = jQuery('#aside-open'),
		btnClose = jQuery('#aside-close'),
		eAside = jQuery('.u-aside'),
		eShadow = jQuery('.u-shadow-aside'),
		btns = btnOpen.add(btnClose).add(eShadow),
		counter = 0;

	function asideToggle(event){
		var aside = event.data.aside,
			shadow = event.data.shadow;

		aside.toggleClass('m-aside-show');
		shadow.toggleClass('m-shadow-show');

		if(counter > 0) {
			aside.toggleClass('m-aside-hide');
			shadow.toggleClass('m-shadow-hide');
		}

		counter++;
	}

	btns.click({
			aside:eAside,
			shadow:eShadow
		},
		asideToggle
	);
})


/* ==============================
 * Gallery
 * ============================== */

jQuery(document).ready(galleryInit);

function galleryInit(){
	var Shuffle = window.Shuffle,
		element = document.querySelector('.b-gallery');

	if( element != null ) {
		// sizer = element.querySelector('.gallery_unit');

		// var shuffleInstance = new Shuffle(element, {
			// itemSelector: '.gallery_unit',
			// sizer: sizer // could also be a selector: '.my-sizer-element'
		// });
	}


	/*
	 * Hover
	 */

	var esGalleryFilterBtn = jQuery('#header-bottom .nav_unit'),
		esGalleryUnitTitle = jQuery('#gallery .gallery_unit');

	esGalleryFilterBtn.unbind('mouseleave');
	esGalleryFilterBtn.unbind('mouseenter');
	esGalleryUnitTitle.unbind('mouseleave');
	esGalleryUnitTitle.unbind('mouseenter');

	hoverNavUnit(esGalleryFilterBtn, 'mouseleave');
	hoverNavUnit(esGalleryFilterBtn, 'mouseenter');

	hoverGalUnit(esGalleryUnitTitle, 'mouseleave');
	hoverGalUnit(esGalleryUnitTitle, 'mouseenter');

	function hoverNavUnit(elms, evnt){
		elms.on(evnt, function(){
			elms.not(this).removeClass('active');
			jQuery(this).toggleClass('active');
			jQuery(this).toggleClass('disable');
		});
	}

	function hoverGalUnit(elms, evnt){
		elms.on(evnt, function(){
			var galUnitTitle = jQuery('.unit_title', this);

			galUnitTitle.toggleClass('active');
			galUnitTitle.toggleClass('disable');
		});
	}


	/*
	 * Filtration
	 */

	esGalleryFilterBtn.unbind('click');
	esGalleryFilterBtn.click(function(){
		// console.log(this);
		loadPostsCategory(this);
		navUnitHover(this);
	})

	function navUnitHover(el){
		var filterArg = jQuery(el).attr('data-groups');

		esGalleryFilterBtn.removeClass('clicked');
		jQuery(el).addClass('clicked');

		if( filterArg == undefined ) {
			jQuery('.b-bunner').slideDown();
			shuffleInstance.filter();
		} else {
			jQuery('.b-bunner').slideUp();
			shuffleInstance.filter( filterArg.slice( 2, filterArg.length-2 ) );
		}
	}


	/*
	 * Zoom Affect
	 */

	esGalleryUnit = jQuery('.b-gallery .unit_img-wrap');
	esGalleryUnit.unbind('mouseenter');
	esGalleryUnit.unbind('mouseleave');

	esGalleryUnit.on('mouseenter', function(){
		var eGalleryImgWrap = jQuery( this ),
			eGalleryImg = jQuery( 'img', eGalleryImgWrap );

		eGalleryImg.transition({
			// width: eGalleryImg.width()*1.1,
			// height: eGalleryImg.height()*1.1,
			transform: 'scale(1.1,1.1)',
			}, 300
		);
	})

	esGalleryUnit.on('mouseleave', function(){
		var eGalleryImgWrap = jQuery( this ),
			eGalleryImg = jQuery( 'img', eGalleryImgWrap );

		eGalleryImg.transition({
			// width: '100%',
			// height: '100%',
			transform: 'scale(1,1)',
			}, 300
		);
	})


	/*
	 * Zoom Affect - resize image wrap
	 */

	esGalleryUnitImgWrap = jQuery('.b-gallery .unit_img-wrap');
	setTimeout(function(){
		esGalleryUnitImgWrap.each( imgWrapResize );
	}, 1000)

	jQuery(window).on('resize', function(){
		esGalleryUnitImgWrap.each( imgWrapResize );
	})

	function imgWrapResize(){
		hGalleryImg = jQuery('.unit_img', this).height();

		jQuery(this).height( hGalleryImg );
	}
}


/* ==============================
 * Video Player
 * ============================== */

jQuery(document).ready(function(){

	/*
	 * Resize
	 */

	var esVideoBunner = jQuery('.b-bunner:has(video)');

	jQuery(window).on('resize', function(){
		esVideoBunner.each(function(i){
			videoResize( jQuery(esVideoBunner.get(i)) );
		});
	})

	esVideoBunner.each(function(i){
		videoResize( jQuery(esVideoBunner.get(i)) );
	});

	function videoResize(bVideoContainer){
		var eVideo = jQuery('.wp-video', bVideoContainer);

		wVideo = eVideo.width();
		bVideoContainer.height( wVideo/2 );
	}


	/*
	 * Autoplay
	 */

	videoAutoplay('.b-bunner.m--autoplay');

	function videoAutoplay(eVideo){
		jQuery('.wp-video-shortcode', eVideo).prop('volume', 0);
		jQuery('video', eVideo).prop('muted', true);
		jQuery('.mejs-overlay-button', eVideo).trigger('click');
		jQuery('.mejs-button.mejs-volume-button.mejs-mute button', eVideo).trigger('click');
	}


	/*
	 * Sound Btn
	 */

	var esVideoShortcode = jQuery('div.wp-video-shortcode');

	btnVideoSound = jQuery('.bunner_sound');
	btnVideoSound.click(videoOnOffSound);

	function videoOnOffSound(){
		var eVideo = jQuery('.wp-video-shortcode', jQuery(this).prev() ),
			eVideoTag = jQuery('video', eVideo);

		if( eVideoTag.prop('muted') == true || eVideo.prop('volume') == 0 ) {
			eVideo.prop('volume', 1);
			eVideoTag.prop('muted', false);
			console.log('on');
		} else {
			eVideo.prop('volume', 0);
			eVideoTag.prop('muted', true);
			console.log('off');
		}
	}

});


/* ==============================
 * Fancy Box.
 * ============================== */

jQuery(document).ready(function(){
	jQuery('[data-fancybox="gallery"]').fancybox({
		keyboard: true,
		infobar: false,
		buttons: [
				"close"
			],
	});
});


/* ===============================
 * AJAX
** =============================== */

var pageCatOne = 1,
	pageCatTwo = 1,
	pageCatThree = 1,
	pageCatFour = 1;


/*
 * Infinite Loop
 */

jQuery(document).ready(function(){
	var page = 2,
		eGallery = jQuery('#gallery'),
		shownPreloader = false,
		onRequest = false,
		resLength = 1;

	jQuery(window).on("scroll", function() {
		return;
		var scrollHeight = jQuery(document).height();

		var scrollPosition = jQuery(window).height() + jQuery(window).scrollTop();
		if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
			if(!shownPreloader){
				// eGallery.append('<img id="preloader" src="http://sonia-a.co.uk/wp-content/themes/View/inc/img/preloader.gif" alt="">');
				shownPreloader = true;
			}

			if(!onRequest){
				if( window.location.href.indexOf("?group=") >= 0 ) {
					var group = window.location.href.slice(
						window.location.href.indexOf("?group=")+7
						);
					console.log(group);
				}

				onRequest = true;
				var ajaxurl = 'http://localhost:90/egofilm/wp-admin/admin-ajax.php';

				jQuery.ajax({
					url: ajaxurl,
					type: 'post',
					data: {
						page: page,
						cat: group,
						action: 'infinite_loop'
					},
					error: function(response){

					},
					success: function(response){
						if( resLength == 0 ) {
							return;
						}

						eGallery.append(response);
						galleryInit();

						// jQuery('#preloader').remove();
						console.log(page);
						page += 1;

						shownPreloader = false;
						onRequest = false;
						resLength = response.length;

						console.log(resLength);
					}

				});

			}
		}
	});

});


/*
 * Change Category
 */

function loadPostsCategory(el){
	var page = 1,
		eGallery = jQuery('#gallery'),
		group = jQuery(el).attr('data-cat'),
		shownPreloader = false,
		onRequest = false,
		resLength = 1;

	onRequest = true;
	var ajaxurl = 'http://localhost:90/egofilm/wp-admin/admin-ajax.php';

	jQuery.ajax({
		url: ajaxurl,
		type: 'post',
		data: {
			page: page,
			cat: group,
			action: 'load_posts_cat'
		},

		error: function(response){
		},

		success: function(response)
		{
			if( resLength == 0 ) {
				return;
			}

			eGallery.html(response);
			galleryInit();
			// console.log(response);

			// jQuery('#preloader').remove();
			// console.log(page);
			page += 1;

			shownPreloader = false;
			onRequest = false;
			resLength = response.length;

			console.log('Response length: '+resLength);
		}

	});
};
